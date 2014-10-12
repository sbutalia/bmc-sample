Angular Test
============

Hello and welcome!

You are provided with the current repository (https://github.com/IvanFarms/test) which is published to http://test.ivanfarms.com/, and with an API server at http://api-test.ivanfarms.com/. 

Your task is to integrate the three following pages using angular: home.html, signin.html, signup.html

The following use cases should be covered:
- The landing home page is home.html
- On the home page, clicking on "sign up" opens the signup page where the user can enter details
- On the signup page, back returns to the home page and do nothing
- On the signup page, clicking on "sign up" launches an API call of the form POST /createUser with data provided in json format; if the call returns an error, the message is displayed and the user stays on the page. Otherwise, the user gets back to the home page where a message says that a user where created.
- On the home page, clicking on "sign in" opens the signin page 
- On the signin page, back returns to the home page and do nothing
- On the signin page, clicking on "sign in" launchs an API call of the form POST /verifyUser with email and code provided in json 
   - If the verifyUser call returns true, the user is redirected to the signup page and a call to GET /user/email retrieves the corresponding data. name and code can be edited and updated through a call to PUT /user/email (instead of the POST /createUser when the user doesn't exists). The email cannot be changed.
   - if the verifyUser call returns false, the user stays on the page and a message "Incorrect email or code is displayed".

The following API calls are provided (also detailled on http://api-test.ivanfarms.com/):

    GET /user/<email> returns { "name": "...", "email": "...", "code": 123} or false
    PUT /user/<email> returns true or false
    POST createUser { "name": "...", "email": "...", "code": 123} returns { "error": true/false, "message": "..."}
    POST verifyUser { "email": "...", "code": 123} returns true or false

You should clone/fork the present repository to your public github account and work on it (or a local copy).

You should create a relevant angularJS modular architecture which would be able to handle new functions (routes).

You shouldn't change any of the current sub-directory (css, js, images, fonts). You should add a specific directory to store the angular files.

Once your app works locally, creates a pull request that includes your name or oDesk ID.

Note that this repository is provided for testing purposes only. It is not intended to work as-is as an actual app, where calls and workflow would be different. All code, text, HTML, CSS, images, and any other assets and examples are the property of ivanfarms technologies.  


Happy coding!
