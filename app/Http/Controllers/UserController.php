<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\JsonResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use JsonResponseTrait;

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|unique:users|email:rfc',
            'phone' => 'required',
            'password' => 'required|min:8|max:20',
            'is_admin' => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return $this->failure($validator->errors()->all());
        }
        $request['password'] = Hash::make($request['password']);
        $user = User::create($request->all());
        $token = $this->issueToken($user);
        return $this->success(['user' => new UserResource($user), 'token' => $token]);
    }

    private function issueToken($user)
    {
        $token = $user->createToken('Laravel Password Grant Client');
        $accessToken = $token->accessToken;
        $expiration = $token->token->expires_at->diffInSeconds(Carbon::now());
        $token = [
            "token_type" => "Bearer",
            "expires_in" => $expiration,
            "access_token" => $accessToken,
        ];
        return $token;
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return $this->failure($validator->errors()->all());
        }
        $credentials = $request->only(['email', 'password']);
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $this->issueToken($user);
            return $this->success(['user' => new UserResource($user), 'token' => $token]);
        }
        return $this->failure([], 'The user credentials were incorrect.', 401);
    }

    public function update(Request $request, User $user)
    {
        $login_user = $request->user();
        if ($login_user->can('update', $user)) {
            $validator = Validator::make($request->all(), [
                'firstname' => 'nullable',
                'lastname' => 'nullable',
                'email' => 'nullable|unique:users|email:rfc',
                'phone' => 'nullable',
                'password' => 'nullable|min:8|max:20',
                'avatar' => 'nullable'
            ]);
            if ($validator->fails()) {
                return $this->failure($validator->errors()->all());
            }
            $input = collect(request()->only([
                'firstname',
                'lastname',
                'email',
                'phone',
                'password',
                'avatar']))
                ->filter(function ($value) {
                    return null !== $value;
                })
                ->toArray();
            if (isset($input['password'])) {
                $input['password'] = Hash::make($request['password']);
            }
            $user->update($input);
            $user->save();
            $user->refresh();
            return $this->success(['user' => new UserResource($user)]);
        }
        return $this->failure([], 'User has no permission.', 403);
    }

    public function delete(Request $request, User $user)
    {
        $login_user = $request->user();
        if ($login_user->can('delete', $user)) {
            try {
                $user->delete();
            } catch (Exception $e) {
                return $this->failure($e->getTrace(), $e->getMessage(), 500);
            }
            return $this->success();
        }
        return $this->failure([], 'User has no permission.', 403);
    }

    public function view(Request $request, User $user)
    {
        $login_user = $request->user();
        if ($login_user->can('view', $user)) {
            return $this->success(['user' => new UserResource($user)]);
        }
        return $this->failure([], 'User has no permission.', 403);
    }

    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'nullable|string|email|max:255',
        ]);
        if ($validator->fails()) {
            return $this->failure($validator->errors()->all());
        }
        $input = collect(request()->only([
            'firstname',
            'lastname',
            'email',
            'phone',]))
            ->filter(function ($value) {
                return null !== $value;
            })
            ->toArray();
        $query = User::query();
        $query->when(isset($input['firstname']), function ($q) use ($input) {
            return $q->where('firstname', 'like', "%{$input['firstname']}%");
        });
        $query->when(isset($input['lastname']), function ($q) use ($input) {
            return $q->where('lastname', 'like', "%{$input['lastname']}%");
        });
        $query->when(isset($input['email']), function ($q) use ($input) {
            return $q->where('email', 'like', "%{$input['email']}%");
        });
        $query->when(isset($input['phone']), function ($q) use ($input) {
            return $q->where('phone', 'like', "%{$input['phone']}%");
        });
        $result = $query->get(['id', 'firstname', 'lastname', 'phone', 'email']);
        return $this->success(['total' => $result->count(), 'data' => $result->toArray()]);
    }

    public function uploadAvatar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => 'image:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return $this->failure($validator->errors()->all());
        }
        $image = $request->file('avatar');
        $image_uploaded_path = $image->store('avatars', 'public');
        $avatar = Storage::disk('public')->url($image_uploaded_path);
        return $this->success(['url' => $avatar]);
    }
}
