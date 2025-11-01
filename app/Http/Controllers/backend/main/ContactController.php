<?php

namespace App\Http\Controllers\backend\main;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Http\Request;
use Psy\Readline\Hoa\Console;
use Yajra\DataTables\DataTables;
class ContactController extends Controller
{
    //Display Contact
    public function AllContact(Request $request)
    {

        if ($request->ajax()) {
            $data = Contact::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function (Contact $data) {
                    $btn = '<a href="' . route('admin.contact.showcontact.editcontact', $data->id) . '"  class="edit mx-3"><i class="fa fa-pen"></i></a>';
                    $btn = $btn . ' <a href="' . route('admin.contact.showcontact.delcontact', $data->id) . '"  class="edit" onclick="return confirm(' . "'Are you sure want to delete record?'" . ')"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })

                ->addColumn('customer', function (Contact $data) {

                    $customer_Det = Customer::where('id', $data->customer_id)->first();
                    return $customer_Det->username;
                })
                ->addColumn('msg_btn', function (Contact $data) {

                    $btn = '<a class="edit mx-3 editdata" value="' . $data->id . '" title="view message" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                            ><i class="fa fa-eye"></i></a>
                          ';

                    return $btn;
                })

                ->addColumn('created_at', function (Contact $data) {
                    $create = $data->created_at->format('m/d/y');
                    return $create;
                })
                ->rawColumns(['action', 'customer', 'msg_btn', 'created_at'])
                ->make(true);
        }

        return view('backend.contact.show_contact');
    }

    // Ajax Data
    public function MsgData(Request $request)
    {
        $content = Contact::where('id',$request->id)->first();
        $html = '';
        $html .='<p class="content">'.  $content->message.'</p>';
        return response()->json($html);

    }

    // Edit Contact
    public function EditContact($id)
    {
        $contact = Contact::where('id', $id)->get();
        return view('backend.contact.edit_contact', compact('contact'));
    }

    // Update Contact
    public function UpdateContact(Request $request, $id)
    {
        $contact_details = Contact::where('id', $id)->first();
        if ($request->customer_id) {
            $request->validate(['customer_id' => 'required|string']);
            Customer::where('id', $contact_details->customer_id)->update(['username' => $request->customer_id]);
        } else {
            $request->validate(['customer_id' => 'required|string']);
        }

        if ($request->subject) {
            $request->validate(['subject' => 'required|string']);
            $subject = $request->subject;
        } else {
            $request->validate(['subject' => 'required|string']);
        }

        if ($request->message) {
            $request->validate(['message' => 'required|string']);
            $message = $request->message;
        } else {
            $request->validate(['message' => 'required|string']);

        }

        $update = Contact::where('id', $id)->update(['subject' => $subject, 'message' => $message]);
        if ($update) {
            session()->flash('msg', 'Update Contact successfully');
            return redirect('admin/contact/showcontact');
        }

    }

    // Delete Contact
    public function DelContact($id)
    {
        $del = Contact::where('id', $id)->delete();
        if ($del) {
            session()->flash('msg', 'Delete Contact successfully');
            return view('backend.contact.show_contact');
        }
    }
}
