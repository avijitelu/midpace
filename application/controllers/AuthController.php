<?php
class AuthController extends Controller {
    protected $authModel;

    public function __construct() {
        $this->authModel = $this->model("AuthModel");
    }

    public function index() {
        Common::redirect("/auth/addon");
    }


    /**
     * @route   /auth/addon
     * @desc    this is admin login page for authenticate admin
     */
    public function addon() {
        $data = [];
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = trim($_POST["email"]);
            $password = trim($_POST["password"]);

            $data["email"]  = $email;

            $admin = $this->authModel->selectAdminByEmail($email);

            if($admin) {
                if(password_verify($password, $admin->password)) {
                    $_SESSION["name"] = $admin->name;
                    $_SESSION["email"] = $admin->email;
                    $_SESSION["user_mode"] = $admin->user_mode;

                    Common::redirect("/addon");
                } else {
                    $data["auth_error"] = "Invalid email or password";
                }
            } else {
                $data["auth_error"] = "Invalid email or password";
            }
        }
        
        echo Twig::getInstance()->render("auth/admin-login.html", $data);
    }

    /**
     * @route   /auth/login
     * @desc    User login route
     */
    public function login() {
        $data = [];
        if($_SERVER['REQUEST_METHOD'] === "POST") {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $data['email'] = $email;

            $user = $this->authModel->selectUserByEmail($email);

            // var_dump($user);
            if($user) {
                if(password_verify($password, $user->user_psw)) {
                    $_SESSION['user_id'] = $user->id;
                    $_SESSION['email'] = $user->email;
                    $_SESSION['user_mode'] = $user->user_mode;
                    $_SESSION['fname'] = $user->fname;

                    Common::redirect("/docpanel");
                } else {
                    $data['auth_error'] = "Authentication failed. You entered an incorrect username or password";
                }
            } else {
                $data['auth_error'] = "Authentication failed. You entered an incorrect username or password";
            }
        }
        echo Twig::getInstance()->render("auth/login.html", $data);
    }


    /**
     * @route   /auth/logout
     * @desc    logout from admin pannel
     */
    public function logout() {
        session_unset();
        session_destroy();

        Common::redirect("/");
    }
}