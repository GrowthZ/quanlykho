/*
 *  Document   : op_auth_signin.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Sign In Page
 */

class pageAuthSignIn {
  /*
   * Init Sign In Form Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
   *
   */
  static initValidation() {
    // Load default options for jQuery Validation plugin
    One.helpers('jq-validation');

    // Init Form Validation
    jQuery('.js-validation-signin').validate({
      rules: {
        'login-username': {
          required: true,
          minlength: 3
        },
        'login-password': {
          required: true,
          minlength: 5
        }
      },
      messages: {
        'login-username': {
          required: 'Hãy nhập tên đăng nhập',
          minlength: 'Tên đăng nhập phải có ít nhất 3 ký tự'
        },
        'login-password': {
          required: 'Hãy nhập mật khẩu',
          minlength: 'Mật khẩu phải có ít nhất 5 ký tự'
        }
      }
    });
  }

  /*
   * Init functionality
   *
   */
  static init() {
    this.initValidation();
  }
}

// Initialize when page loads
One.onLoad(() => pageAuthSignIn.init());
