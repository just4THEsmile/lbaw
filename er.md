# ER: Requirements Specification Component

- Project Vision
> The application has in the sight to manage a community of collaborative questions and answers, where anyone can submit questions or answers, in which has the objective to facilitate the discussion of ideas/resources between the users, easing the communication.

## A1: Collaborative Q&A

- Goals, business context and environment.  
> The main target of Collaborative Q&A is to create a information system with a web interface to manage a community of collaborative questions and answers. Any resgistered user can submit questions and answers. The questions and answers can be voted on by the rest of the community. It's also possible to associate brief comments to the questions or the answers. Each user has an associated score that is calculated considering the votes on its questions and answers.
> There will be a team of administrators / moderators that will be responsible to manage the application , whether it's making sure that the app is running smoothly or ensuring that the illegal content is removed and punishing the user accordingly.
- Motivation.  
> With the development of the new technologies, it's starting to be noticeable that most Q&A sites are becoming more and more outdated and depecrated. So we decided to build a new web application where we innovate the way the Q&A works, so that it attracts new and old users.
- Main features.
    - User
        - View Top Questions

        - View Recent Questions

        - Browse Questions

        - Browse Questions by Tags

        - View Question Details

        - View User Profiles
    - Authenticated User
        - View Personal Feed

        - Post Question

        - Post Answer

        - Vote on Questions

        - Vote on Answers

        - Comment on Questions

        - Comment on Answers

        - View My Questions

        - View My Answers

        - Follow Question

        - Follow Tags

        - Report Content

        - Support User Badges
    - {Question, Answer, Comment} Author
        - Edit Question

        - Delete Question

        - Edit Answer

        - Delete Answer

        - Edit Comment

        - Delete Comment

    - Question Author
        - Edit Question Tags

        - Mark Answer as Correct
    - Moderator
        - Delete Content

        - Edit Question Tags

        - Manage Content Reports
    - Notifications
        - Answer to Question

        - Vote on Content

        - Badge Award
    - Administrator
        - Manage Tags


---


## A2: Actors and User stories

> The Actors and the User Stories manage the dependencies/specifications about the type of users of the Collaborative Q&A. We can use this as a feasible and simple documentation to the project requirements and necessities.


### 1. Actors

> For our app, Collaborative Q&A, the actors belonging to it are represented bellow:

![actors](uploads/ac5daac19d53155dda9c14a29524466c/actors.png)
*Image 1:  Collaborative Q&A Actors Diagram*

> The table bellow will describe succinctly each one of the actors:

|Actor|Description|
|----|----|
|User| Broad user that has acess to the app.|
|Visitors|Generic  users that can see most of public information and features and they aren't signed in the app. |
|Authenticated|Authenticated users that can do what the previous can , plus acess to more information and features, such as giving likes/dislikes and creating questions.|
|Comment Author| Authenticated Users that can edit or delete their comment.|
|Question Author| Authenticated Users that can edit or delete their question.|
|Answer Author| Authenticated Users that can edit or delete their answer in another user's question.|
|Moderator|Authenticated Users that can delete any sort of content (Comment, Question and Answer) and edit Question Tags.|
|Administrator|Authenticated User that is responsible to manage Tags.|~

*Table 1:  Collaborative Q&A Actors Description*




### 2. User Stories

> For each one of our features of the app, there is associated user story.

#### 2.1. User

#### 2.2. Visitor

#### 2.3. Authenticated User

#### 2.3. Comment Author

#### 2.3. Question Author

#### 2.3. Answer Author

#### 2.3. Moderator

#### 2.3. Administrator


### 3. Supplementary Requirements

> Section including business rules, technical requirements, and restrictions.  
> For each subsection, a table containing identifiers, names, and descriptions for each requirement.

#### 3.1. Business rules

#### 3.2. Technical requirements

#### 3.3. Restrictions


---


## A3: Information Architecture

> Brief presentation of the artifact goals.


### 1. Sitemap

> Sitemap presenting the overall structure of the web application.  
> Each page must be identified in the sitemap.  
> Multiple instances of the same page (e.g. student profile in SIGARRA) are presented as page stacks.


### 2. Wireframes

> Wireframes for, at least, two main pages of the web application.
> Do not include trivial use cases (e.g. about page, contacts).


#### UIxx: Page Name

#### UIxx: Page Name


---


## Revision history

Changes made to the first submission:
1. Item 1
1. ...

***
GROUPYYgg, DD/MM/20YY

* Group member 1 name, email (Editor)
* Group member 2 name, email
* ...