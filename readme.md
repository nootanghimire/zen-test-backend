#Test: Zen Rooms Backend Project

[![Build Status](https://travis-ci.org/nootanghimire/zen-test-backend.svg?branch=master)](https://travis-ci.org/nootanghimire/zen-test-backend)


#Some Stuffs to Say
I know it is a good practice to use Laravel's API routes to write APIs for applications, but this project merely uses
web routes and protect it with auth middleware.

The tests are written so that it does not take care of middlewares, so that should not be a problem.

I chose this way because 
a) Old Habits,
b) This is a time bound project, and 
c) Because Kent Beck once said,
    - Make it work, Make it right, Make it fast.

and I'm just making it work right now 

#The Plan
To summerize, the plan is to:

##Pre-Dev
  - Design Basic Schema
  - Write API Docs 
  - Figure out rough implementation structure
  - Write a simple plan

##In-Dev
  - Write Tests for API, 
  - Pass those tests
  - Write a minimal UI resembling to the given task
  - Join APIs and UI
  - If enough time, move web routes to API routes
  - Use OAuth or similar stuff for auth rather than relying on cookies and sessions


##Post-Dev
  - Look for optimizations in Pre-Dev
  - Look for required changes in In-Dev
  - Iterate


#Build
  - See .travis.yml for all build script

#Broken Things
  - Angular (or more correct, JS, or more correct Web Standards) Date Validation is kind of broken (angularjs issue  #6881)
