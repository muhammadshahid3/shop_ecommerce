<?php

namespace App\Http\Controllers\backend\main;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductRating;
use DB;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    // All Customers
    public function AllCustomers(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function (Customer $data) {
                    $btn = '<a href="' . route('admin.customer.show.editcustomer', $data->id) . '"  class="edit mx-3"><i class="fa fa-pen-alt"></i></a>';
                    $btn = $btn . ' <a href="' . route('admin.customer.show.delcustomer', $data->id) . '"  class="edit" onclick="return confirm(' . "'Are you sure want to delete customer?'" . ')"><i class="fa fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->addColumn('status', function (Customer $data) {

                    if ($data->status == "A") {
                        return "Active";
                    } else {
                        return "InActive";
                    }
                })
                ->addColumn('created_at', function (Customer $data) {
                    $create = $data->created_at->format('m/d/y');
                    return $create;
                })
                ->rawColumns(['action', 'created_at', 'status'])
                ->make(true);
        }
        return view('backend.customers.customer');
    }

    // Add Customer 
    public function AddCustomer()
    {
        return view('backend.customers.add_customer');
    }

    // Store Customer
    public function StoreCustomer(Request $request)
    {
        $request->validate([
            'username' => 'required|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|unique:customers',
            'password' => 'required|digits:6',
            'phone_number' => 'required|numeric|unique:customers|min:11'
        ]);
        // Password Encrypt
        $password = bcrypt($request->password);
        $create_customer = Customer::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => $password,
            'phone_number' => $request->phone_number,
            'status' => "A"
        ]);
        if ($create_customer) {
            session()->flash('msg', 'Add Customer Successfully');
            return redirect('admin/customer/show');
        }
    }

    // Edit Customer
    public function EditCustomer($id)
    {
        $customer_data = Customer::where('id', $id)->get();
        return view('backend.customers.edit_customer', compact('customer_data'));
    }

    // Update Customer
    public function UpdateCustomer(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|regex:/^[\pL\s\-]+$/u',
            'email' =>  'required|unique:customers,email,'.$id,
            'phone_number' => "required|numeric|min:11"
        ]);

        $update = Customer::where('id', $id)->update([
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number
        ]);
        if ($update) {
            session()->flash('msg', 'Update Customer Successfully');
            return redirect('admin/customer/show');
        }
    }

    // Delete Customer
    public function DelCustomer($id)
    {
        $del_customer = Customer::where('id', $id)->delete();
        if ($del_customer) {
            session()->flash('msg', 'Delete Customer Successfully');
            return redirect('admin/customer/show');
        }
    }

    // All Customer Ratings
    public function AllRating(Request $request)
    {
        if ($request->ajax()) {
            $data = ProductRating::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function (ProductRating $data) {
                    $btn = '<a href="' . route('admin.customer.rating.edit', $data->id) . '"  class="edit mx-3"><i class="fa fa-pen-alt"></i></a>';
                    $btn = $btn . ' <a href="' . route('admin.customer.rating.del', $data->id) . '"  class="edit" onclick="return confirm(' . "'Are you sure want to delete this record?'" . ')"><i class="fa fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->addColumn('customer_name', function (ProductRating $data) {
                    // Relation
                    if (isset($data->customers->username)) {
                        return $data->customers->username;
                    } else {
                        return "Empty";
                    }

                })

                ->addColumn('product_name', function (ProductRating $data) {
                    // Relation
                    if (isset($data->products->product_name)) {
                        return $data->products->product_name;
                    } else {
                        return "Empty";
                    }

                })

                ->addColumn('category_name', function (ProductRating $data) {
                    // Relation
                    if (isset($data->categories->category_name)) {
                        return $data->categories->category_name;
                    } else {
                        return "Empty";
                    }

                })

                ->addColumn('view_icon', function (ProductRating $data) {
                    $view_icon = '<a class="edit mx-3 review_data" value="' . $data->id . '"  data-bs-toggle="modal"  data-bs-target="#staticBackdrop" title="view message"><i class="fa fa-eye"></i></a>';
                    return $view_icon;
                })

                ->addColumn('created_at', function (ProductRating $data) {
                    $create = $data->created_at->format('m/d/y');
                    return $create;
                })
                ->rawColumns(['action', 'customer_name', 'product_name', 'category_name', 'view_icon', 'created_at'])
                ->make(true);
        }
        return view('backend.customers.customer_rating.show_rating');
    }

    // Custoemr Review Message
    public function ReviewMessage(Request $request)
    {
        $html = '';
        $review_msg = ProductRating::where('id', $request->review_message_id)->first();
        $html .= '<p class="content">' . $review_msg->review_message . '</p>';
        return response()->json($html);
    }

    // Edit Customer
    public function EditRating($id)
    {
        $arr_pass['single_rating_details'] = ProductRating::where('id', $id)->first();
        return view('backend.customers.customer_rating.edit_rating', $arr_pass);
    }

    // Update Customer Rating
    public function UpdateRating(Request $request)
    {
            $request->validate([
                'customer_id' => 'required|string',
                'category_id' => 'required|string',
                'product_id' => 'required|string',
                'stars' => 'required|numeric',
                'review_message' => 'required',
            ]);
            
        Customer::where('id',$request->old_customer_id)->update(['username'=> $request->customer_id]);
        Category::where('id',$request->old_category_id)->update(['category_name'=> $request->category_id]);
        Product::where('id',$request->old_product_id)->update(['product_name'=> $request->product_id]);
       $Update_Rating = ProductRating::where('id',$request->rating_id)
        ->update(['stars'=>$request->stars,'review_message' =>$request->review_message]);
        if($Update_Rating){
            session()->flash('msg', 'Update Review Successfully');
            return redirect('admin/customer/rating');
        }
    }

    // Delete Customer Rating
    public function DelRating($id)
    {
        $delete_review = ProductRating::where('id', $id)->delete();
        if ($delete_review) {
            session()->flash('msg', 'Delete Review Successfully');
            return redirect('admin/customer/rating');
        }
    }

}

