<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // show all listings
    public function index(){
       //  if you wanna use this :dd($request['tag']); --------> add this berfore index(Request $request)
       // dd(request(['tag']));

        return view('listing.index',[
            'listings'=>Listing::latest()->filter(request(['tag',"search"]))->Paginate(5)
        ]);
    }

    // show signle listing
    public function show(Listing $listing){
        return view("listing.show",[
            "listing"=>$listing
        ]);
    }

     // create listing
     public function create(){
        return view("listing.create");
    }

     // store listing
     public function store(Request $request){
        $formfileds=$request->validate([
           "title"=>'required',
           "tags"=>'required',
           "company"=> ['required',Rule::unique('listings','company')],            
           "location"=>'required',
           "email"=>['required','email'],
           "website"=>'required',
            "description"=>'required'
        ]);
        if($request->hasFile('logo')){
            $formfileds['logo']=$request->file('logo')->store('logos','public');
        }
        $formfileds['user_id']=auth()->id();

        Listing::create($formfileds);
         return  redirect("/")->with('message','listing created seccusfully');

    }

     // show edite Listing
     public function edit(Listing $listing){
        return view("listing.edit" ,['listing'=>$listing]);
    }
     // update 
     public function update(Request $request,Listing $listing){
      
        // check if the user is the owner of this listing
        if($listing->user_id !=auth()->user()->id){
            abort(403,"Unauthorized action");
        }

        $formfileds=$request->validate([
            "title"=>'required',
            "tags"=>'required',
            "company"=> ['required'],            
            "location"=>'required',
            "email"=>['required','email'],
            "website"=>'required',
             "description"=>'required'
         ]);
         if($request->hasFile('logo')){
             $formfileds['logo']=$request->file('logo')->store('logos','public');
         }
 
         $listing->update($formfileds);
          return  back()->with('message','listing updated seccusfully');
        
    }

    // delete method 

      // show edite Listing
      public function destroy(Listing $listing){
         // check if the user is the owner of this listing
         if($listing->user_id !=auth()->user()->id){
            abort(403,"Unauthorized action");
        }
        $listing->delete();
        return redirect("/")->with('message','listing deleted seccusfully');
    }
    public function manage(){
    
        return view("listing.manage",[
            'listings'=>auth()->user()->listings()->get()]);
    }
}
