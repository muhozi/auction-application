<?php
namespace App\Http\Controllers\PublicControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Auth;
use App\AuctionProducts;
class SellingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prod = new AuctionProducts();
        return view('sellProduct');
    }
    public function saveAuctionProduct(Request $request)
    {
        if ($request->hasFile('productPicture')) {
            
        }
        $data = $request->all();
        $validate = \Validator::make($data,[
            'productName'=>'required',
            'minimalPrice'=>'required|numeric|min:500',
            'auctionEndTime'=>'required',
            'description'=>'required',
            'productPicture'=>['required','mimes:jpeg,bmp,png',Rule::dimensions()->minWidth(300)->minHeight(300)]
            ]);
        if ($validate->fails()) {
            return redirect()->back()->withInput()->withErrors($validate->errors());
        }
        $filename = str_replace(' ', '_', $request->input("productName"))."_".$request->input("minimalPrice")."_".time().str_random(30).'.'.$request->productPicture->getClientOriginalExtension();
        $request->productPicture->move(public_path().'/img/products',$filename);
        $product = new AuctionProducts();
        $product->user_id = Auth::user()->id;
        $product->product_name = $request->input("productName");
        $product->minimal_price = $request->input("minimalPrice");
        $product->end_date_time = $request->input("auctionEndTime")/*.' '.$request->input("auctionEndTime")*/;
        $product->picture = $filename;
        $product->description = $request->input("description");
        $product->save();
        return redirect()->back()->withMessage('Successfully product has put on Auction market');

    }
    public function sold(){
        $products = Auth::user()->auctions();
        return view('soldProducts')->with('products',$products);
    }
    public function soldProductDetails($id){
        $product = Auth::user()->auctions($id);
        return view('soldProductsDetails')->with('product',$product);
    }
    public function soldProductClose($id){
        $product = Auth::user()->auctions($id);
        $product->sold = 1;
        $product->save();
        return redirect()->back()->withMessage('Your Auction has been successfully closed');
    }
    public function soldProductDelete($id){
        $product = Auth::user()->auctions($id);
        $product->forceDelete();
        return redirect()->route('sold');
    }
}
