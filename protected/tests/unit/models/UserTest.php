<?php

/**
 * Unit testing for User model class.
 * 
 * This class is used to test User model class using PHPUnit.
 * 
 * @author Petra Barus <petra.barus@gmail.com>
 * @package application.tests.unit.models
 */
class UserTest extends CDbTestCase {

        /**
         * General rules testing method.
         * 
         * This method will test all of the rules in User model class that
         * aren't specified to any specific scenario, i.e. applies in all of
         * scenarios.
         */
        public function testGeneralRules() {
                //Testing username regex rule.
                $user = new User();
                //False testcases
                $testcases = array(
                        'user', //length less than 6
                        'username.', //using dot
                        '1username', //using number in first character
                        'usern$'
                );
                foreach ($testcases as $testcase) {
                        $user->username = $testcase;
                        $user->validate(); //Invoking rule testing.
                        $this->assertTrue($user->hasErrors('username'));
                }
                
                //Testing email
                //False Testcase
                $user->username = 'userad';
                $testcases = array(
                        'adin@po', // no domain
                        'adin@.c', // no subdomain
                        'adin.co', // no @
                        '@a.co', // no user
                );
                foreach ($testcases as $testcase) {
                        $user->email = $testcase;
                        $user->validate();
                        $this->assertTrue($user->hasErrors('email'));
                }
                
                //Test password
                $testcases = array(
                        'p', // < 4
                        'adi', // < 4
                        'aaaaabbbbbaaaaabbbbbaaaaabbbbbccc', // > 32
                );
                foreach ($testcases as $testcase) {
                        $user->email = $testcase;
                        $user->validate();
                        $this->assertTrue($user->hasErrors('email'));
                }
                
                
        }
        public function testLoginScenario(){
                $user = new User(User::SCENARIO_LOGIN);
                $user->attributes = array (
                    'username' => 'dainaad',
                );
                $this->assertFalse($user->validate());
                
                
                $user = new User(User::SCENARIO_LOGIN);
                $user->attributes = array (
                    'password' => 'dainaad',
                );
                $this->assertFalse($user->validate());
                
                
                $user = new User(User::SCENARIO_LOGIN);
                $user->attributes = array (
                    'password' => 'daia',
                    'username' => 'aaaaaa'
                );
                $this->assertTrue($user->validate());
        }
        
        public function testRegisterScenario(){
                $user = new User(User::SCENARIO_REGISTER);
                $user->attributes = array (
                    'username' => 'dainaad',
                    'email' => 'ad@a.com',
                    'password' => 'pass',
                    'passwordRepeat' => 'pass',
                    'fullName' => 'adin'
                );
                $this->assertTrue($user->validate());
                
                $user->attributes = array (
                    'username' => 'dainaad',
                    'email' => 'ad@a.com',
                    'password' => 'pass',
                    'passwordRepeat' => 'passs',
                    'fullName' => 'adin'
                );
                $this->assertFalse($user->validate());
                
                $user->attributes = array (
                    'username' => 'dainaad',
                    'email' => 'ad@a.com',
                    'password' => '',
                    'passwordRepeat' => 'pass',
                    'fullName' => 'adin'
                );
                $this->assertFalse($user->validate());
                
                $user->attributes = array (
                    'username' => 'dain',
                    'email' => 'ad@a.com',
                    'password' => 'pass',
                    'passwordRepeat' => 'pass',
                    'fullName' => 'adin'
                );
                $this->assertFalse($user->validate());
        }
}