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

> According to our implementation, additionally to using the laravel built-in functions, we also created some php function to validate the inputs. For example, we ask for a minimum of length 8 for the password, or we ask for a minimum of 16 in content of the question.

### 5. Check Accessibility and Usability

> we had two forms that forms that were sent by javascript althought we could do them without we implemented tag search when selecting making them more easy to select
>
> Accessibility: [Accessibility](../reports/acessibilidade.pdf) [17/18]
>
> Usability: [Accessibility](../reports/usabilidade.pdf) [27/28]

### 6. HTML & CSS Validation

> Provide the results of the validation of the HTML and CSS code using the following tools. Include the results as PDF files in the group's repository. Add individual links to those files here.
>   
> HTML: https://validator.w3.org/nu/  
> CSS: https://jigsaw.w3.org/css-validator/  

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
|  US01          | US Name 1 | Module A | High | **John Silva**, Ana Alice   |  100%  |
|  US02          | US Name 2 | Module A | Medium | **Ana Alice**, John Silva                 |   75%  | 
|  US03          | US Name 3 | Module B | Low | **Francisco Alves**                 |   5%  | 
|  US04          | US Name 4 | Module A | Low | -                 |   0%  | 

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