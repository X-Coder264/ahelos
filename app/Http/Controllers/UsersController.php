<?php

namespace Ahelos\Http\Controllers;

use Ahelos\Order;
use Ahelos\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

    /**
     * Show a list of all the users.
     *
     * @return Response
     */
    public function index()
    {
        // Show the page
        return view('admin.users.index');
    }

    /**
     * Pass data through ajax call
     */
    public function data()
    {
        $users = User::withTrashed()->get(['id', 'name', 'surname', 'email','created_at', 'deleted_at']);

        return DataTables::of($users)
            ->editColumn('created_at', function(User $user) {
                Carbon::setLocale('hr');
                return $user->created_at->diffForHumans();
            })->editColumn('deleted_at', function(User $user) {
                if ($user->trashed()) {
                    return 'Deaktiviran';
                } else {
                    return 'Aktiviran';
                }
            })->addColumn('actions', function($user) {
                $actions = '<a href='. route('admin.users.show', $user->id) .'><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428bca" title="Pogledaj korisnika"></i></a>';
                if(!$user->trashed()) {
                    $actions .= '<a href='. route('admin.users.edit', $user->id) .'><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428bca" title="Izmjeni podatke korisnika"></i></a>';
                }

                if ((Auth::user()->id != $user->id) && ($user->id != 1 && !$user->trashed())) {
                    $actions .= '<a href='. route('admin.users.confirm-delete', $user->id) .' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="user-remove" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="Deaktiviraj korisnika"></i></a>';
                } elseif ($user->trashed()) {
                    $actions .= '<a href='. route('admin.users.confirm-restore', $user->id) .' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="user-flag" data-c="#6CC66C" data-hc="#6CC66C" data-size="18" title="Aktiviraj korisnika"></i></a>';
                }
                return $actions;
            })->rawColumns(['actions'])->make(true);
    }

    /**
     * Create new user view
     *
     * @return Response
     */
    public function create()
    {
        // Show the page
        return view('admin.users.create');
    }

    /**
     * Store user in the DB
     *
     * @param Request $request
     * @return Redirect
     */
    public function store(Request $request)
    {
        $user = User::create($request->except('_token', 'password_confirm'));
        
        return back();
    }

    /**
     * User update view
     *
     * @param  User $user
     * @return Response
     */
    public function edit(User $user)
    {
        // lazy eager load the user with his printers (soft deleted printers too)
        $user->load(['printers' => function ($query) {
            $query->withTrashed();
        }]);
        
        // Show the page
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the user in the DB
     *
     * @param  User $user
     * @param Request $request
     * @return Redirect
     */
    public function update(User $user, Request $request)
    {
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->email = $request->input('email');
        $user->place = $request->input('place');
        $user->address = $request->input('address');
        $user->post = $request->input('post');
        $user->company = $request->input('company');
        $user->company_id = $request->input('company_id');
        $user->phone = $request->input('phone');
        if($request->has('admin')) {
            $user->admin = true;
        } elseif(Auth::user()->id === $user->id) {
            $user->admin = true;
        } elseif($user->id !== 1) {
            $user->admin = false;
        }

        $user->save();

        $success = "Promjene su uspješno spremljene.";

        // Redirect to the user page
        return Redirect::route('admin.users.edit', $user)->with('success', $success);
    }

    /**
     * Show a list of all the deleted users.
     *
     * @return Response
     */
    public function getDeletedUsers()
    {
        // Grab deleted users
        $users = User::onlyTrashed()->get();

        // Show the page
        return view('admin.deleted_users', compact('users'));
    }


    /**
     * Delete Confirm
     *
     * @param   int $id
     * @return Response
     */
    public function getModalDelete($id = null)
    {
        $type = 'delete';
        $confirm_route = $error = null;
        // Get user information
        $user = User::find($id);

        // Check if we are not trying to delete ourselves
        if ($user->id === Auth::user()->id) {
            // Prepare the error message
            $error = "You can't delete yourself.";

            return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        }
        $confirm_route = route('admin.users.delete', ['id' => $user->id]);
        return view('admin.layouts.modal_confirmation', compact('error', 'type', 'confirm_route', 'user'));
    }

    /**
     * Delete the given user.
     *
     * @param  int $id
     * @return Redirect
     */
    public function destroy($id = null)
    {
        // Get user information
        $user = User::find($id);

        // Check if we are not trying to delete ourselves
        if ($user->id === Auth::user()->id) {
            // Prepare the error message
            $error = "You can't delete yourself.";

            // Redirect to the user management page
            return Redirect::route('admin.users.index')->with('error', $error);
        }

        // Soft Delete the user
        $user->delete();

        // Prepare the success message
        $success = "The user has been deleted";

        // Redirect to the user management page
        return Redirect::route('admin.users.index')->with('success', $success);
    }

    /**
     * Restore Confirm
     *
     * @param   int $id
     * @return Response
     */
    public function getModalRestore($id = null)
    {
        $type = 'restore';
        $confirm_route = $error = null;
        // Get user information
        $user = User::withTrashed()->find($id);

        // Check if we are not trying to delete ourselves
        if ($user->id === Auth::user()->id) {
            // Prepare the error message
            $error = "You can't activate yourself.";

            return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        }
        $confirm_route = route('admin.users.restore', ['id' => $user->id]);
        return view('admin.layouts.modal_confirmation', compact('error', 'type', 'confirm_route', 'user'));
    }

    /**
     * Restore a deleted user.
     *
     * @param  int $id
     * @return Redirect
     */
    public function getRestore($id = null)
    {
        // Get user information
        $user = User::withTrashed()->find($id);

        // Restore the user
        $user->restore();

        // Prepare the success message
        $success = "You successfully activated this user.";

        // Redirect to the user management page
        return Redirect::route('admin.users.index')->with('success', $success);
    }

    /**
     * Display specified user profile.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        // Get the user information
        $user = User::withTrashed()->find($id);

        // Show the page
        return view('admin.users.show', compact('user'));

    }

    /**
     * Display user orders.
     *
     * @param  int $id
     * @return Response
     */
    public function showOrders($id)
    {
        $orders = Order::where('user_id', '=', $id)->get();

        return DataTables::of($orders)
            ->editColumn('created_at', function(Order $order) {
                Carbon::setLocale('hr');
                return $order->created_at->format('d.m.Y. H:i:s') . " (" . $order->created_at->diffForHumans() . ")";
            })->editColumn('updated_at', function(Order $order) {
                Carbon::setLocale('hr');
                return $order->updated_at->format('d.m.Y. H:i:s') . " (" . $order->updated_at->diffForHumans() . ")";
            })->addColumn('actions', function(Order $order) {
                $actions = '<a href='. route('admin.user.order.show', ['order' => $order]) .'><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428bca" title="Pregledaj narudžbu"></i></a>';
                return $actions;
            })->make(true);

    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function passwordreset($id, Request $request)
    {
        $rules = [
            'password' => 'required|min:6|confirmed',
        ];

        $messages = [
            'password.required' => 'Morate unijeti lozinku.',
            'password.min' => 'Lozinka mora imati barem 6 znakova.',
            'password.confirmed' => 'Lozinke se ne podudaraju.',
        ];


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->getMessageBag()->toArray()]);
        } else {
            $user = User::find($id);
            $user->password = Hash::make($request->input('password'), ['rounds' => 15]);
            $user->save();

            return response()->json(['status' => 'success']);
        }
    }
}
