<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth; 
use Session; 
use App\Category; 
use App\Product; 
use App\ProductsAttribute;
use Illuminate\Support\Facades\Input; 
use Image; 

class ProductsController extends Controller
{
    //
    public function addProduct(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $product = new Product;
            if(empty($data['category_id'])){
                return redirect()->back()->with('flash_message_error','Under Category is missing!');
            }
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            if(!empty($data['description'])){
                $product->description = $data['description'];
            }else{
                $product->description = '';
            }
            $product->price = $data['price'];
            //Upload Image
            if($request->hasFile('image')){
                $image_imp = Input::file('image');
                if($image_imp->isValid()){
                    $extension = $image_imp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $large_image_path = 'images/backend_images/products/large/'.$filename;
                    $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                    $small_image_path = 'images/backend_images/products/small/'.$filename;
                    //Resize Images
                    Image::make($image_imp)->save($large_image_path);
                    Image::make($image_imp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_imp)->resize(300,300)->save($small_image_path);
                    //Store image name in products table
                    $product->image = $filename;
                }
            }
            $product->save(); 
            //return redirect()->back()->with('flash_message_success','Product has been added successfully!');
            return redirect('/admin/view-products')->with('flash_message_success','Category Added Successfully!');
        }

        //categories_dropdown
        $categories = Category::where(['parent_id'=>0])->get();
        $categories_dropdown = "<option value='' selected disabled>Select</option>";
        foreach($categories as $cat){
            $categories_dropdown.="<option value='".$cat->id."'>".$cat->name."</option>";
            $sub_categories = Category::where(['parent_id'=>$cat->id])->get();
            foreach($sub_categories as $sub_cat){
                $categories_dropdown.="<option value='".$sub_cat->id."'>---".$sub_cat->name."</option>";
            }
        }
        return view('admin.products.add_product')->with(compact('categories_dropdown'));
    }

    public function viewProducts(){
        $products = Product::get();
        //$products = json_decode(json_encode($products));
        foreach($products as $key => $val){
            $category_name = Category::where(['id'=>$val->category_id])->first();
            $products[$key]->category_name = $category_name->name;
        } 
        //echo "<pre>"; print_r($products); die;
        return view('admin.products.view_products')->with(compact('products'));
    }

    public function editProduct(Request $request, $id=null){
        //Update Product
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            //Upload Image
            if($request->hasFile('image')){
                $image_imp = Input::file('image');
                if($image_imp->isValid()){
                    $extension = $image_imp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $large_image_path = 'images/backend_images/products/large/'.$filename;
                    $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                    $small_image_path = 'images/backend_images/products/small/'.$filename;
                    //Resize Images
                    Image::make($image_imp)->save($large_image_path);
                    Image::make($image_imp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_imp)->resize(300,300)->save($small_image_path);
                }
            }else{
                $filename=$data['current_image'];
            }

            if(empty($data['description'])){
                $data['description']='';
            }

            Product::where(['id'=>$id])->update(['category_id'=>$data['category_id'],'product_name'=>$data['product_name'],
            'product_code'=>$data['product_code'],'product_color'=>$data['product_color'],'description'=>$data['description'],
            'price'=>$data['price'],'image'=>$filename]);
            //return redirect('/admin/view-products')->with('flash_message_success','Product Updated Successfully!');
            return redirect()->back()->with('flash_message_success','Product updated successfully!');
        }

        //Get product Detail
        $productsDetails = Product::where(['id'=>$id])->first();

        //Categories Dropdown
        $categories = Category::where(['parent_id'=>0])->get();
        $categories_dropdown = "<option value='' selected disabled>Select</option>";
        foreach($categories as $cat){
            if($cat->id==$productsDetails->category_id){
                $selected = 'selected';
            }else{
                $selected = '';
            }
            $categories_dropdown.="<option value='".$cat->id."'".$selected.">".$cat->name."</option>";
            $sub_categories = Category::where(['parent_id'=>$cat->id])->get();
            foreach($sub_categories as $sub_cat){
                if($sub_cat->id==$productsDetails->category_id){
                    $selected = 'selected';
                }else{
                    $selected = '';
                }
                $categories_dropdown.="<option value='".$sub_cat->id."'".$selected.">---".$sub_cat->name."</option>";
            }
        }
        return view('admin.products.edit_product')->with(compact('productsDetails','categories_dropdown'));
    }

    public function deleteProductImage($id=null){
        if(!empty($id)){
            Product::where(['id'=>$id])->update(['image'=>'']);
            return redirect()->back()->with('flash_message_success','Product image delete successfully!');
        }
    }

    public function deleteProduct($id=null){
        if(!empty($id)){
            Product::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','Product Delete Successfully!');
        }
    }

    public function addAttributes(Request $request, $id=null){
        $productDetails = Product::with('attributes')->where(['id'=>$id])->first();
        //$productDetails = json_decode(json_encode($productDetails));        
        //echo "<pre>"; print_r($productDetails); die;

        if($request->isMethod('post')){
            $data = $request->all();
             //echo "<pre>"; print_r($data); die;
            foreach($data['sku'] as $key => $val){
                if(!empty($val)){
                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $val;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->save();
                }
            }
            return redirect('/admin/add-attributes/'.$id)->with('flash_message_success','Product Attribute nas been added Successfully!');
        }
        return view('admin.products.add_attributes')->with(compact('productDetails'));
    }

    public function deleteAttribute($id=null){
        //if(!empty($id)){
            ProductsAttribute::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','Product Attribute Delete Successfully!');
        //}
    }
}
