<?php

namespace App\Http\Controllers;

use App\Models\ProductsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProductsModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/api/products",
     *      operationId="getProductsList",
     *      tags={"Products"},
     *      summary="Get list of products",
     *      description="Returns list of products",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index()
    {
        $products = ProductsModel::all();
        foreach ($products as $product) {
            $product->picture =  url(ProductsModel::PRODUCT_STORAGE . $product->picture);
        }
        return response()->json([
            'success' => true,
            'data' => $products
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *      path="/api/storeProduct",
     *      operationId="createProduct",
     *      tags={"Products"},
     *      summary="Create Product",
     *      
     *      description="Returns created Product data",
     *      @OA\Parameter(
     *          name="name",
     *          description="Product name",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="description",
     *          description="Product description",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="picture",
     *          description="Product picture",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="file",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="price",
     *          description="Product price",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function store(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->all()
        ], Response::HTTP_OK);
        $validator = Validator::make($request->all(), 
                      [ 
                      'name' => 'required',
                      'description' => 'required',
                      'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                      'price' => 'required',
                     ]);  

         if ($validator->fails()) {  

               return response()->json(['error'=>$validator->errors()], 401); 

        }
        $product = null;
        
        if (request()->file('picture')) {
            $ext = request()->file('picture')->getClientOriginalExtension();
            $productName = 'product_' . time() . '.' . $ext;

            $path = request()->file('picture')->storeAs('public/products', $productName);
            
            $product = new ProductsModel();
            $product->name = $request->name;
            $product->description = $request->description;
            $product->picture = $productName;
            $product->price = $request->price;
            $product->save();
            $product->picture =  url(ProductsModel::PRODUCT_STORAGE . $product->picture);
        }
        

        return response()->json([
            'success' => true,
            'data' => $product
        ], Response::HTTP_OK);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductsModel  $productsModel
     * @return \Illuminate\Http\Response
     */
    public function show(ProductsModel $productsModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductsModel  $productsModel
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Put(
     *      path="/api/editProducts/{id}",
     *      operationId="editProduct",
     *      tags={"Products"},
     *      summary="Update Product",
     *      description="Returns updated Product data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Product id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="name",
     *          description="Product name",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     * 
     *      @OA\Parameter(
     *          name="description",
     *          description="Product description",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="picture",
     *          description="Product picture",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="file",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="price",
     *          description="Product price",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function edit(Request $request, $id)
    {
        
        $validator = Validator::make($request->all(), 
                      [ 
                      'name' => 'required',
                      'description' => 'required',
                      'price' => 'required',
                     ]);  

         if ($validator->fails()) {  

            return response()->json(['error'=>$validator->errors()], 401); 

        }  
        $product = ProductsModel::find($id);
        if(!$product){
            return response()->json([
            'success' => false,
        ], Response::HTTP_NOT_FOUND);
        }
        
        
        if (request()->file('picture')) {
            $path = "products/" . $product->picture;
            if(Storage::exists($path)){
                Storage::delete($path);
            }
            $ext = request()->file('picture')->getClientOriginalExtension();
            $productName = 'product_' . time() . '.' . $ext;

            request()->file('picture')->storeAs('public/products', $productName);
            $product->name = $request->name;
            $product->description = $request->description;
            $product->picture = $productName;
            $product->price = $request->price;
            $product->save();
            $product->picture =  url(ProductsModel::PRODUCT_STORAGE . $product->picture);
        }else{
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->save();
            $product->picture =  url(ProductsModel::PRODUCT_STORAGE . $product->picture);
        }
        // $product->name = $request->name;
        // $product->price = $request->price;
        // $product->save();

        return response()->json([
            'success' => true,
            'data' => $product
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductsModel  $productsModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductsModel $productsModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductsModel  $productsModel
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Delete(
     *      path="/api/deleteProduct/{id}",
     *      operationId="deleteProduct",
     *      tags={"Products"},
     *      summary="Delete existing Product",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Product id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function destroy($id)
    {
        $product = ProductsModel::find($id);
        if(!$product){
            return response()->json([
            'success' => false,
        ], Response::HTTP_NOT_FOUND);
        }
        $product->delete();
        return response()->json([
            'success' => true,
        ], Response::HTTP_OK);
    }
}
