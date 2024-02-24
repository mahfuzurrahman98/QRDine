<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;

class ItemController extends Controller {
    public function index() {
        $categories = auth()->user()->restaurant->categories;
        $items = Item::where('category_id', [$categories->pluck('id')->toArray()])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('items.index', ['items' => $items]);
    }

    public function create() {
        $categories = auth()->user()->restaurant->categories;
        return view('items.create', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return redirect()->back()->withError($error)->withInput();
        }

        try {
            $item = new Item();
            $item->name = $request->name;
            $item->description = $request->description;
            $item->price = $request->price;
            $item->active = $request->active == 'on' ? 1 : 0;
            $item->category_id = $request->category_id;

            // Handle image upload if provided
            if ($request->hasFile('image')) {
                $restoSlug = auth()->user()->restaurant->slug;
                $image = $request->file('image');
                // time_uuid
                $originalImageName = time() . '_' . Str::uuid();
                $baseDir = "uploads/restaurants/$restoSlug/items";

                // create directory in the /public directory if not exists
                if (!file_exists(public_path($baseDir))) {
                    mkdir(public_path($baseDir), 0777, true);
                }

                // Define image names with size suffix
                $imageNameOriginal = $originalImageName . '_original.jpg';
                $imageNameSmall = $originalImageName . '_small.jpg';
                $imageNameLarge = $originalImageName . '_large.jpg';

                // Save original image
                $image->move(public_path($baseDir), $imageNameOriginal);

                // Create and save small version of the image
                $smallImage = Image::read(public_path($baseDir . '/' . $imageNameOriginal));
                $smallImage->cover(200, 200);
                $smallImage->save(public_path($baseDir . '/' . $imageNameSmall));

                // Create and save large version of the image
                $largeImage = Image::read(public_path($baseDir . '/' . $imageNameOriginal));
                $largeImage->cover(500, 400);
                $largeImage->save(public_path($baseDir . '/' . $imageNameLarge));

                // Store the original image name (or whichever you prefer) in the database
                $item->image = $originalImageName;
            }

            $item->save();

            return redirect()->route('items')->withStatus('Item added successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage())->withInput();
        }
    }

    public function edit(Item $item) {
        $categories = auth()->user()->restaurant->categories;
        return view('items.edit', [
            'item' => $item,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, Item $item) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return redirect()->back()->withError($error)->withInput();
        }

        try {
            $item->name = $request->name;
            $item->description = $request->description;
            $item->price = $request->price;
            $item->active = $request->active == 'on' ? 1 : 0;
            $item->category_id = $request->category_id;

            // Handle image upload if provided
            if ($request->hasFile('image')) {
                $restoSlug = auth()->user()->restaurant->slug;
                $image = $request->file('image');
                // time_uuid
                $originalImageName = time() . '_' . Str::uuid();
                $baseDir = "uploads/restaurants/$restoSlug/items";

                // create directory in the /public directory if not exists
                if (!file_exists(public_path($baseDir))) {
                    mkdir(public_path($baseDir), 0777, true);
                }

                // Define image names with size suffix
                $imageNameOriginal = $originalImageName . '_original.jpg';
                $imageNameSmall = $originalImageName . '_small.jpg';
                $imageNameLarge = $originalImageName . '_large.jpg';

                // Save original image
                $image->move(public_path($baseDir), $imageNameOriginal);

                // Create and save small version of the image
                $smallImage = Image::read(public_path($baseDir . '/' . $imageNameOriginal));
                $smallImage->cover(200, 200);
                $smallImage->save(public_path($baseDir . '/' . $imageNameSmall));

                // Create and save large version of the image
                $largeImage = Image::read(public_path($baseDir . '/' . $imageNameOriginal));
                $largeImage->cover(500, 400);
                $largeImage->save(public_path($baseDir . '/' . $imageNameLarge));

                // Delete old images
                if ($item->image) {
                    $oldImageOriginal = public_path($baseDir . '/' . $item->image . '_original.jpg');
                    $oldImageSmall = public_path($baseDir . '/' . $item->image . '_small.jpg');
                    $oldImageLarge = public_path($baseDir . '/' . $item->image . '_large.jpg');

                    if (file_exists($oldImageOriginal)) {
                        unlink($oldImageOriginal);
                    }
                    if (file_exists($oldImageSmall)) {
                        unlink($oldImageSmall);
                    }
                    if (file_exists($oldImageLarge)) {
                        unlink($oldImageLarge);
                    }
                }

                // Store the original image name (or whichever you prefer) in the database
                $item->image = $originalImageName;
            } else if ($request->has('image_ex')) {
                // delete old images
                $restoSlug = auth()->user()->restaurant->slug;
                $baseDir = "uploads/restaurants/$restoSlug/items";
                $oldImageOriginal = public_path($baseDir . '/' . $item->image . '_original.jpg');
                $oldImageSmall = public_path($baseDir . '/' . $item->image . '_small.jpg');
                $oldImageLarge = public_path($baseDir . '/' . $item->image . '_large.jpg');

                if (file_exists($oldImageOriginal)) {
                    unlink($oldImageOriginal);
                }
                if (file_exists($oldImageSmall)) {
                    unlink($oldImageSmall);
                }
                if (file_exists($oldImageLarge)) {
                    unlink($oldImageLarge);
                }

                $item->image = '';
            }

            $item->save();

            return redirect()->back()->withStatus('Item updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage())->withInput();
        }
    }

    public function destroy(Item $item) {
        try {
            $restoSlug = auth()->user()->restaurant->slug;
            $baseDir = "uploads/restaurants/$restoSlug/items";
            $imageOriginal = public_path($baseDir . '/' . $item->image . '_original.jpg');
            $imageSmall = public_path($baseDir . '/' . $item->image . '_small.jpg');
            $imageLarge = public_path($baseDir . '/' . $item->image . '_large.jpg');

            if (file_exists($imageOriginal)) {
                unlink($imageOriginal);
            }
            if (file_exists($imageSmall)) {
                unlink($imageSmall);
            }
            if (file_exists($imageLarge)) {
                unlink($imageLarge);
            }

            $item->delete();
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }
}
