# PA: Product and Presentation

## A9: Product

>Q&A functions as an online discussion hub catering to both seasoned developers and newcomers, fostering knowledge exchange on various topics.

>Within Q&A, users have the liberty to elaborate questions linked to specific categories. Users also possess the ability to contribute answers to questions and engage in discussions via comments. To ensure a self-regulating community, the platform employs a system where users can vote (up or down) on questions or answers, and report any inappropriate content. Community members who garner trust through their reputation points are elegible to gain certain badges and the possibility to become a moderator, which can moderate all content, including editing and deleting others' posts. The platform offers advanced search functionalities, employing matching to scour both question titles and content, and enabling users to refine their searches by filtering through categories.

>This artifact serves to outline the functionalities embedded within our platform, in addition to providing insights into the developmental specifics of the product. 

### 1. Installation

> Link to the release with the final version of the source code in the group's Git repository.  
> Full Docker Command: docker run -it -p 8000:80 --name=lbaw2357 -e DB_DATABASE="lbaw2357" -e DB_SCHEMA="lbaw2357" -e DB_USERNAME="lbaw2357" -e DB_PASSWORD="EYrQzbEb" git.fe.up.pt:5050/lbaw/lbaw2324/lbaw2357

### 2. Usage

> URL to the product: https://lbaw2357.lbaw.fe.up.pt/ 

#### 2.1. Administration Credentials
  

| Email | Password |
| -------- | -------- |
| admin@example.com    | 1234 |
| moderator@example.com  | 12345678 |

*Table 71: Administration credentials*


#### 2.2. User Credentials

| Type          | Username  | Password |
| ------------- | --------- | -------- |
| Authenticated User | kanderson@example.net    | 12345678 |

*Table 72: User credentials*

### 3. Application Help

> For starters, whenever anything goes wrong, there will be displayed a message error explaining the reason for the error and how to handle it. For example, if a user wants to create another account unblock request, instead of creating another request, it will display 'Unblock request already exists.'

>Our approach to navigation is to ensure uniform user experience across every page by maintaining consistent layouts for the navigation bar, sidebar and footer, along with standardized color schemes throughout the site.

>Finally, we also implemented icons in certain buttons/links instead of the text, to facilitate the interpretation and readibility. Not only that, but whenever I want to see the user's profile of a question, I can simply press the username, and it will redirect to it's profile.

### 4. Input Validation

> According to our implementation, additionally to using the laravel built-in functions, we also created some php function to validate the inputs. For example, we ask for a minimum of length 8 for the password, or we ask for a minimum of 16 in content of the question we require a unique username and a unique email as well as every tag has an unique name.

### 5. Check Accessibility and Usability

> Provide the results of accessibility and usability tests using the following checklists. Include the results as PDF files in the group's repository. Add individual links to those files here.
>
> Accessibility: [Accessibility](../reports/Accessibility.pdf)
> Usability: [Usability](../reports/Accessibility.pdf)

### 6. HTML & CSS Validation

> Provide the results of the validation of the HTML and CSS code using the following tools. Include the results as PDF files in the group's repository. Add individual links to those files here.
>   
> HTML: [HTML](https://git.fe.up.pt/lbaw/lbaw2324/lbaw2357/-/tree/main/reports/html?ref_type=heads)
> CSS: [CSS](../reports/css/css.pdf)

### 7. Revisions to the Project

> Describe the revisions made to the project since the requirements specification stage.  


### 8. Implementation Details

#### 8.1. Libraries Used


| Name | Reference | Description of Use | Example |
|:---:|:-------:|:-------------------------------------------:|:-------:|
|Laravel|[Reference](https://laravel.com/)|Laravel is utilized to expedite back-end development by establishing a secure and modular framework that implements standard website functionalities.|[Using laravel csrf to login](https://lbaw2357.lbaw.fe.up.pt/login)
|Bootstrap|[Reference](https://getbootstrap.com/)|Employed to front-end development, it enhances aesthetics and responsiveness, elevating the visual appeal and usability of designs.|[User Profile Settings](https://lbaw2357.lbaw.fe.up.pt/editprofile/13) 

*Table 73: Libraries Used*

#### 8.2 User Stories

> This subsection should include all high and medium priority user stories, sorted by order of implementation. Implementation should be sequential according to the order identified below. 
>
> If there are new user stories, also include them in this table. 
> The owner of the user story should have the name in **bold**.
> This table should be updated when a user story is completed and another one started. 

| US Identifier | Name    | Module | Priority                       | Team Members               | State  |
| ------------- | ------- | ------ | ------------------------------ | -------------------------- | ------ |
|US01|View Top Questions |M01|High|Tomás|100%|
|US02|View Recent Questions|M01|High|Tomás|100%|
|US03|Browse Questions|High|M01|Tomás Diogo|100%|
|US04|Browse Questions by Tags|M01|Medium|Tomás Diogo|100%|
|US05|View Question Details|M01|Medium|Tomás|100%|
|US06|View User Profiles|M01|Medium|Rodrigo Tomás Diogo|100%|
|US07|Log-in the System|M02|High|Rodrigo|100%|
|US08|Register in the System|M02|High|Rodrigo|100%|
|US09|Logout|M03|High|Rodrigo|100%|
|US10|View Profile|M03|High|Rodrigo Diogo|100%|
|US12|Edit Profile|M03|High|Rodrigo|100%|
|US13|Search Exact Match|M03|High|Tomás|100%|
|US14|Search Full-Text|M03|Low|Tomás|100%|
|US15|View Personal Feed|M03|High|Tomás Diogo|100%|
|US16|Post Question|M03|High|Tomás|100%|
|US17|Post Answer|M03|High|Tomás|100%|
|US18|View My Questions|M03|High|Tomás Rodrigo|100%|
|US19|View My Answers|M03|High|Tomás Rodrigo|100%|
|US20|Recover Password|M03|Medium|Rodrigo|100%|
|US21|Delete Account|M03|Medium|Rodrigo|100%|
|US22|Support Profile Picture|M03|Low|Rodrigo|100%|
|US23|View Personal Notifications|M03|Medium|Tomás|100%|
|US24|Search over Multiple Attributes|M03|Low|Tomás|100%|
|US25|Search Filters|M03|Medium|Tomás|100%|
|US26|Vote on Questions|M03|Medium|Diogo|100%|
|US27|Vote on Answers|M03|Medium|Diogo|100%|
|US28|Comment on Questions|M03|Medium|Tomás|100%|
|US29|Comment on Answers|M03|Medium|Tomás|100%|
|US30|Follow Question|M03|Medium|Rodrigo|100%|
|US31|Follow Tags|M03|Medium|Tomás|100%|
|US32|Placeholders in Form Inputs|M03|Medium|Diogo Rodrigo|100%|
|US33|Contextual Error Messages|M03|Medium|Rodrigo Tomás Diogo|100%|
|US34|Contextual Help|M03|Low|Rodrigo Tomás Diogo|100%|
|US35|About US|M03|Low|Rodrigo Diogo|100%|
|US36|Main Features|M03|Low|Diogo Rodrigo|100%|
|US37|Contacts|M03|Medium|Diogo Rodrigo|100%|
|US38|Appeal for Unblock|M03|Low|Rodrigo|100%|
|US39|Ordering of the results|M03|Low|Tomás Rodrigo|100%|
|US40|Report Content|M03|Low|Rodrigo|100%|
|US41|Support User Badges|M03|Low|Rodrigo|100%|
|US42|Donations|M03|Low|Diogo|80%|
|US43|User number of Answers|M03|Low|Rodrigo|100%|
|US44|User number of Questions|M03|Low|Rodrigo|100%|
|US44|User Points|M03|Low|Rodrigo|100%|
|US45|Edit Question|M04|High|Tomás|100%| 
|US46|Delete Question|M04|High|Tomás|100%| 
|US47|Edit Answer|M04|High|Tomás|100%| 
|US48|Delete Answer|M04|High|Tomás|100%|
|US49|Delete Comment|M04|Medium|Tomás|100%|
|US50|Edit Question Tags|M04|Medium|Tomás|100%|
|US51|Mark Answer as Correct|M04|Medium|Diogo|100%|
|US51|Delete Content|M05|Medium|Tomás Rodrigo|100%|
|US52|Edit Question Tags|M05|Medium|Tomás|100%|
|US53|Manage Content Reports|M05|Low|Rodrigo|100%|
|US54|Administer User Accounts (search, view, edit, create)|M06|High|Rodrigo|100%|
|US55|Manage Tags|M06|Medium|Tomás Diogo Rodrigo|100%|
|US56|Administrator Accounts|M06|Medium|Rodrigo|100%|
|US57|Block and Unblock User Accounts|M06|Medium|Rodrigo|100%|
|US58|Delete User Account|M06|Medium|Rodrigo|100%|
*Table 74: Implemented User Stories*


## A10: Presentation
 

### 1. Product presentation

> Introducing QthenA—an innovative web-based information system revolutionizing the Q&A landscape. Our platform is meticulously designed to empower a vibrant community of users to effortlessly post questions, share thoughts through answers, and engage in dynamic discussions. With a simple yet amazing interface and robust functionalities such as voting, commenting, and personalized scoring, QthenA fosters a collaborative environment where knowledge is shared, curated, and valued. Supported by vigilant administrators and moderators, we ensure a seamless user experience while upholding content integrity and community standards.

> At its core, QthenA is driven by the commitment to redefine the Q&A experience. With user focused features like customizable profiles and advanced search capabilities, our platform transcends the traditional question-and-answer format. QthenA is a platform grounded with HTML5, CSS, JavaScript. It also uses the Laravel framework and Bootstrap framework.

> URL to the product: https://lbaw2357.lbaw.fe.up.pt/login  
>


### 2. Video presentation

> Screenshot of the video plus the link to the lbawYYgg.mp4 file.

> - Upload the lbawYYgg.mp4 file to Moodle.
> - The video must not exceed 2 minutes.


---


## Revision history

Changes made to the first submission:
1. Item 1
1. ..

***
GROUPYYgg, DD/MM/20YY

* Group member 1 name, email (Editor)
* Group member 2 name, email
* ...