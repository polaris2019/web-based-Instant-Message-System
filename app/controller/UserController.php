<?php
namespace app\controller;

use app\BaseController;
use app\model\User;
use think\facade\Validate;
use think\facade\Session;
use think\facade\View;
use think\facade\Log;
use think\facade\Db;
use think\facade\Request;

class UserController extends BaseController
{
    // Display registration page
    public function registerPage()
    {
        // If user is already logged in, redirect to chat
        if (Session::has('user_id')) {
            return redirect((string)url('/chat'));
        }
        return View::fetch('user/register');
    }

    // Display login page
    public function loginPage()
    {
        // If user is already logged in, redirect to chat
        if (Session::has('user_id')) {
            return redirect((string)url('/chat'));
        }
        return View::fetch('user/login');
    }

    // User registration
    public function register()
    {
        if (!$this->request->isPost()) {
            return json(['code' => 0, 'msg' => 'Invalid request method']);
        }

        $data = $this->request->post();
        
        // Define validation rules
        $validate = Validate::rule([
            'username' => 'require|min:3|max:20|unique:user',
            'password' => 'require|min:6',
            'email'    => 'require|email|unique:user'
        ]);

        // Validate input
        if (!$validate->check($data)) {
            return json(['code' => 0, 'msg' => $validate->getError()]);
        }

        Db::startTrans();
        try {
            // Hash password
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            
            // Create user
            $user = new User;
            $user->save([
                'username' => $data['username'],
                'password' => $data['password'],
                'email'    => $data['email'],
                'status'   => 1
            ]);

            Db::commit();
            return json(['code' => 1, 'msg' => 'Registration successful']);
        } catch (\Exception $e) {
            Db::rollback();
            Log::error('Registration failed: ' . $e->getMessage());
            return json(['code' => 0, 'msg' => 'Registration failed: ' . $e->getMessage()]);
        }
    }

    // User login
    public function login()
    {
        Log::info('Login attempt started');
        
        if (!$this->request->isPost()) {
            Log::warning('Invalid request method for login');
            return json(['code' => 0, 'msg' => 'Invalid request method']);
        }

        $data = $this->request->post();
        Log::info('Login attempt for user: ' . ($data['username'] ?? 'unknown'));
        
        // Validate input
        $validate = Validate::rule([
            'username' => 'require',
            'password' => 'require'
        ]);

        if (!$validate->check($data)) {
            Log::warning('Login validation failed: ' . $validate->getError());
            return json(['code' => 0, 'msg' => $validate->getError()]);
        }

        try {
            // Find user
            $user = User::where('username', $data['username'])->find();
            
            if (!$user) {
                Log::warning('Login failed: User not found - ' . $data['username']);
                return json(['code' => 0, 'msg' => 'Invalid username or password']);
            }

            // Verify password
            if (!password_verify($data['password'], $user->password)) {
                Log::warning('Login failed: Invalid password for user - ' . $data['username']);
                return json(['code' => 0, 'msg' => 'Invalid username or password']);
            }

            // Update last login time
            $user->last_login = date('Y-m-d H:i:s');
            $user->save();

            // Set session
            Session::set('user_id', $user->id);
            Session::set('username', $user->username);

            Log::info('User logged in successfully: ' . $user->username);
            
            // Get base URL
            $baseUrl = Request::domain();
            $redirectUrl = $baseUrl . '/chat';
            Log::info('Redirect URL: ' . $redirectUrl);
            
            return json([
                'code' => 1, 
                'msg' => 'Login successful', 
                'redirect' => $redirectUrl,
                'debug' => [
                    'session_id' => session_id(),
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'base_url' => $baseUrl
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return json(['code' => 0, 'msg' => 'Login failed: ' . $e->getMessage()]);
        }
    }

    // User logout
    public function logout()
    {
        try {
            $userId = Session::get('user_id');
            $username = Session::get('username');
            
            // 更新用户的最后登录时间
            if ($userId) {
                $user = User::find($userId);
                if ($user) {
                    $user->last_login = date('Y-m-d H:i:s', time() - 301);  // 设置为5分钟前，确保显示离线
                    $user->save();
                }
            }
            
            Session::clear();
            Log::info('User logged out: ' . $username);
            return json([
                'code' => 1,
                'msg' => 'Logout successful',
                'redirect' => (string)url('/user/login')
            ]);
        } catch (\Exception $e) {
            Log::error('Logout error: ' . $e->getMessage());
            return json(['code' => 0, 'msg' => 'Logout failed: ' . $e->getMessage()]);
        }
    }

    // Get user profile
    public function profile()
    {
        $userId = Session::get('user_id');
        if (!$userId) {
            return json(['code' => 0, 'msg' => 'Not logged in']);
        }

        try {
            $user = User::find($userId);
            if (!$user) {
                return json(['code' => 0, 'msg' => 'User not found']);
            }

            return json([
                'code' => 1,
                'data' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'last_login' => $user->last_login,
                    'status' => $user->status
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Profile error: ' . $e->getMessage());
            return json(['code' => 0, 'msg' => 'Failed to get profile: ' . $e->getMessage()]);
        }
    }
}
