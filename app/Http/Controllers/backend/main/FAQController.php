<?php

namespace App\Http\Controllers\backend\main;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
class FAQController extends Controller
{
    // All FAQS
    public function AllFaq(Request $request)
    {
        if ($request->ajax()) {
            $data = FAQ::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function (FAQ $data) {
                    $btn = '<a href="' . route('admin.faqs.edit', $data->id) . '"  class="edit mx-3"><i class="fa fa-pen"></i></a>';
                    $btn = $btn . ' <a href="' . route('admin.faqs.del', $data->id) . '"  class="edit" onclick="return confirm(' . "'Are you sure want to delete record?'" . ')"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })

                ->addColumn('view_icon', function (FAQ $data) {
                    $btn = '<a class="edit mx-3 answer_btn" value="' . $data->id . '" title="view_answer" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa fa-eye"></i></a>';
                    return $btn;
                })

                ->addColumn('created_at', function (FAQ $data) {
                    $create = $data->created_at->format('m/d/y');
                    return $create;
                })
                ->rawColumns(['action', 'view_icon', 'created_at'])
                ->make(true);
        }
        return view('backend.faqs.show_faq');
    }

    // Add Faq
    public function AddFaq()
    {
        return view('backend.faqs.add_faq');
    }

    // Store FAQ
    public function StoreFaq(Request $request)
    {
        $create_Faq = FAQ::create(['question' => $request->question, 'answer' => $request->answer]);
        if ($create_Faq) {
            session()->flash('msg', 'Add FAQ Successfully');
            return redirect('admin/faqs');
        }
    }

    // View Faq Message
    public function ViewFAQ(Request $request)
    {
        $html = '';
        $answer = FAQ::where('id', $request->faq_id)->first();
        $html .= '<p class="content">' . $answer->answer . '</p>';
        return response()->json($html);
    }

    // Edit FAQ
    public function EditFaq($id)
    {
        $arr_pass['faq_details'] = FAQ::where('id', $id)->first();
        return view('backend.faqs.edit_faq', $arr_pass);
    }

    // Update FAQ
    public function UpdateFaq(Request $request)
    {
        $update_faq = FAQ::where('id', $request->faq_id)->update(['question' => $request->question, 'answer' => $request->answer]);
        if ($update_faq) {
            session()->flash('msg', 'Update FAQ Successfully');
            return redirect('admin/faqs');
        }
    }

    // Delete FAQ
    public function DelFaq($id)
    {
       $del_faq= FAQ::where('id',$id)->delete();
       if($del_faq){
        session()->flash('msg', 'Delete FAQ Successfully');
        return redirect('admin/faqs');
       }
    }
}
