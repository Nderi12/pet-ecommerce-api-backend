<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\Builder;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['login', 'register', 'resetPassword']]);
    }

    /**
     * Registers a new user
     *
     * @OA\Post(
     *     path="/v1/admin/register",
     *     tags={"Authentication"},
     *     summary="Registers a new user",
     *     description="Registers a new user with the specified details",
     *     operationId="registerUser",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Fields needed to register a new user",
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="phone_number", type="string", example="0123456789"),
     *             @OA\Property(property="address", type="string", example="123 Main Street, Anytown, USA"),
     *             @OA\Property(property="password", type="string", minLength=8, example="secretpassword")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully registered."),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation errors encountered during registration",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     * )
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'phone_number' => 'required',
            'address' => 'required',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'message' => 'Successfully registered.',
            'user' => $user,
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/admin/login",
     *     summary="Logs in a user by providing email and password credentials",
     *     description="Logs in a user and retrieves an access token",
     *     tags={"Authentication"},
     *     @OA\Response(
     *         response="200",
     *         description="User logged in successfuly",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully logged in."),
     *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImtpZCI6ImZhNjViODlk...[jwt access token]")
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Invalid email or password",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid email or password.")
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="The credential details of the user",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", example="john_doe@example.com"),
     *             @OA\Property(property="password", type="string", example="password")
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $user->update([
                'last_logged_in' => Carbon::now(),
            ]);

            $token = $this->issueToken($user->id);

            return response()->json([
                'message' => 'Successfully logged in.',
                'token' => $token,
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'Invalid email or password.',
        ], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out.',
        ], Response::HTTP_OK);
    }

    public function resetPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $user->update(['password' => bcrypt($request->password)]);

        $token = $this->issueToken($user->id);

        return response()->json([
            'message' => 'Password reset successfully.',
            'token' => $token,
        ], Response::HTTP_OK);
    }

    public function issueToken($user_id)
    {
        $tokenBuilder = (new Builder(new JoseEncoder(), ChainedFormatter::default()));
        $algorithm = new Sha256();
        $signingKey = InMemory::plainText(random_bytes(32));

        $now = new DateTimeImmutable();
        $token = $tokenBuilder
            // Configures the issuer (iss claim)
            ->issuedBy(config('app.url'))
            // Configures the audience (aud claim)
            ->permittedFor(config('app.url'))
            // Configures the id (jti claim)
            // ->identifiedBy('4f1g23a12aa')
            // Configures the time that the token was issue (iat claim)
            ->issuedAt($now)
            // Configures the time that the token can be used (nbf claim)
            ->canOnlyBeUsedAfter($now->modify('+1 minute'))
            // Configures the expiration time of the token (exp claim)
            ->expiresAt($now->modify('+1 hour'))
            // Configures a new claim, called "uid"
            ->withClaim('uid', $user_id)
            // Configures a new header, called "foo"
            ->withHeader('foo', 'bar')
            // Builds a new token
            ->getToken($algorithm, $signingKey);

        return $token->toString();
    }
}
