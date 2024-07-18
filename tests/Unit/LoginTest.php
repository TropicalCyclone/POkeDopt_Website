<?php

    use PHPUnit\Framework\TestCase;

    class LoginTest extends TestCase {

        public function testSuccessfulLogin() {

            $login = new App\Login;
            $result = $login->authenticate('admin', 'password');
            $this->assertEquals('Login successful', $result);
            echo 'Login successful.';

        }

        public function testFailedLoginWithWrongPassword() {

            $login = new App\Login;;
            $result = $login->authenticate('admin', 'wrongPassword');
            $this->assertEquals('Login successful', $result);
            echo 'Login failed.';

        }

        public function testFailedLoginWithWrongUsername() {

            $login = new App\Login;
            $result = $login->authenticate('wrongUser', 'password');
            $this->assertEquals('Login failed', $result);
            echo 'Login failed.';

        }

    }

?>