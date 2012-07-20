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
                );
                foreach ($testcases as $testcase) {
                        $user->username = $testcase;
                        $user->validate(); //Invoking rule testing.
                        $this->assertTrue($user->hasErrors('username'));
                }
        }

}