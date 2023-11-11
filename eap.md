# EAP: Architecture Specification and Prototype

> This element organizes items associated with the high-level architectural plan of the information system under development, as well as the vertical prototype created to confirm the validity of the architecture.

## A7: Web Resources Specification

> This document provides a summary of the web resources intended for inclusion in the vertical prototype, categorized into modules. It's outlined the permissions applied to these modules, defining the access conditions for the resources. The web resources are described according to the OpenAPI standard, detailing the expected URL, supported HTTP methods, parameters, and potential responses for each resource.

### 1. Overview

| Modules | Description |
|---------|-------------|
| M01: Authentication | Web resources associated with user authentication, including system features such as login/logout and registration.|
| M02: User | Web resources associated with individual profile management, including system features such as view and edit personal profile information, view personal notifications and followed questions.|
| M03: Commentables & Comments| Web resources associated with questions, answers and comments, including system features such as add, view, vote, report and delete questions,answers and comments.|
| M04: Search | Web resources correspond to search features. Including searching users, questions with different types of filter and order. |
| M05: Administration | Web resources related to implementing terms of service enforcement, user blocking, unblocking, and banning, as well as functionalities for deleting posts/comments and updating static pages.|
| M06: Static Pages |Web resources with static content are in this module.|

*Table 62: QthenA Resources Overview*
### 2. Permissions

> This section defines the permissions used in the modules to establish the conditions of access to resources, in increasing order of restrictiveness.

| Identifier | Name | Description |
|------------|------|-------------|
| PUB | Public | An unauthenticated user. |
| USR | User | An authenticated user. |
| MOD | Moderator | An moderator. |
| ADM | Administrator | Platform administrator. |

*Table 63: QthenA Permissions*

### 3. OpenAPI Specification

> OpenAPI specification in YAML format to describe the vertical prototype's web resources.

> Link to the `a7_openapi.yaml` file in the group's repository.


```yaml

openapi: 3.0.0
info:
 version: '1.0'
 title: 'LBAW QthenA API'
 description: 'Web Resources Specification (A7) for MediaLibrary'

servers:
- url: http://lbaw.fe.up.pt
  description: Production server


tags:
 - name: 'M01: Authentication'
 - name: 'M02: User'
 - name: 'M03: Commentables & Comments'
 - name: 'M04: Search'
 - name: 'M05: Administration'
 - name: 'M06: Static Pages'
paths:

  /login:
    get:
      operationId: R101
      summary: 'R101: Login Form'
      description: 'Provide login form. Access: PUB'
      tags:
        - 'M01: Authentication'
      responses:
        '200':
          description: 'Ok. Show Log-in UI'
    post:
      operationId: R102
      summary: 'R102: Login Action'
      description: 'Processes the login form submission. Access: PUB'
      tags:
        - 'M01: Authentication'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                email:          # <!--- form field name
                  type: string
                  format: email
                password:    # <!--- form field name
                  type: string
                  format: password
              required:
                - email
                - password

      responses:
        '302':
          description: 'Redirect after processing the login credentials.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful authentication. Redirect to user profile.'
                  value: '/users/{id}'
                302Error:
                  description: 'Failed authentication. Redirect to login form.'
                  value: '/login'


  /register:
    get:
      operationId: R103
      summary: 'R103: Register Form'
      description: 'Provide register form. Access: PUB'
      tags:
        - 'M01: Authentication'
      responses:
        '200':
          description: 'Ok. Show Register UI'
    post:
      operationId: R104
      summary: 'R104: Register Action'
      description: 'Processes the register form submission. Access: PUB'
      tags:
        - 'M01: Authentication'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                username:          # <!--- form field name
                  type: string
                email:          # <!--- form field name
                  type: string
                  format: email
                password:    # <!--- form field name
                  type: string
                  format: password
                confirm_password:    # <!--- form field name
                  type: string
                  format: password
              required:
                - username
                - email
                - password
                - confirm_password

      responses:
        '302':
          description: 'Redirect after processing the register credentials.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful authentication. Redirect to user profile.'
                  value: '/users/{id}'
                302Error:
                  description: 'Failed resgister. Redirect to register form.'
                  value: '/register'
  /user/{id}:
    get:
      operationId: R201
      summary: 'R201: User'
      description: 'Provide User Profile. Access: USR'
      tags:
        - 'M02: User'
      responses:
        '200':
          description: 'Ok. Show User Profile'  
        '302':
          description: 'Ok. Show Register UI' 

  /user/edit:
    get:
      operationId: R202
      summary: 'R202: Edit Profile Form'
      description: 'Provide Edit Profile Form. Access: USR'
      tags:
        - 'M02: User'
      responses:
        '200':
          description: 'Ok. Show Edit Profile page UI'
        '302':
          description: 'Ok. Show Register UI' 
    post:
      operationId: R203
      summary: 'R203: Edit Profile Action'
      description: 'Edits the profile of the user. Access: USR'
      tags:
        - 'M02: User'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                name:          # <!--- form field name
                  type: string
                username:    # <!--- form field name
                  type: string
                email:    # <!--- form field name
                  type: string
                  format: email
                password:    # <!--- form field name
                  type: string
                  format: password
                confirm_password:    # <!--- form field name
                  type: string
                  format: password
                bio:    # <!--- form field name
                  type: string
              required:
                - name
                - username
                - email
                - bio

      responses:
        '302':
          description: 'Redirect after processing the Edit profile.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful edition. Redirect to user profile.'
                  value: '/users/{id}'
                302Error:
                  description: 'Failed edition. Redirect to login form.'
                  value: '/user/edit'

```


## A8: Vertical prototype

> Brief presentation of the artifact goals.

### 1. Implemented Features

#### 1.1. Implemented User Stories

> Identify the user stories that were implemented in the prototype.  

| User Story reference | Name                   | Priority                   | Description                   |
| -------------------- | ---------------------- | -------------------------- | ----------------------------- |
| US01                 | Name of the user story | Priority of the user story | Description of the user story |

...

#### 1.2. Implemented Web Resources

> Identify the web resources that were implemented in the prototype.  

> Module M01: Module Name  

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R01: Web resource name | URL to access the web resource |

...

> Module M02: Module Name  

...

### 2. Prototype

> URL of the prototype plus user credentials necessary to test all features.  
> Link to the prototype source code in the group's git repository.  


---


## Revision history

Changes made to the first submission:
1. Item 1
1. ..

***
GROUP2357, 20/11/2023
 
* Group member 1 Diogo Sarmento, up202109663@fe.up.pt (editor of A7/A8)
* Group member 2 Rodrigo Povoa , up202108890@fe.up.pt (editor of A7/A8)
* Group member 3 Tomás Sarmento, up202108778@fe.up.pt (editor of A7/A8)
