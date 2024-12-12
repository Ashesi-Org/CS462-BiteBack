# CS462-EcoMomentum

EcoMomentum Platform

Objective
The EcoMomentum Website is an online platform created to advocate for climate action and environmental sustainability. The goal is to raise awareness about the impacts of climate change while fostering a sense of community and shared responsibility. The platform serves as a central hub for:

1. Awareness
Providing accessible and engaging educational resources such as articles, videos, infographics, and data on climate change, its causes, effects, and the urgent actions needed to address it globally.
2. Event Promotion
Maintaining a calendar of EcoMomentum events, including local and international climate strikes, workshops, and other related initiatives. Users can explore events happening nearby or in other regions.
3. Community Building
Offering a platform for individuals to take action, sign up for events, share their climate stories, and connect with other activists and supporters

Pipeline
User Interface Layer
Overview
The User Interface (UI) is designed to be intuitive and engaging, offering users easy navigation to explore climate strike events, access educational resources, and track their activism.

Features
Web Application: A responsive web interface that adapts to both desktop and mobile devices.
Login/Registration: Secure account creation and login, allowing users to manage profiles and track their involvement in climate strikes and campaigns.
Event Participation: Users can browse upcoming events, sign up for participation, and receive updates on event status.
Community Features: Discussion boards, group chats, and connections for local and global engagement with other activists and event organizers.
Data Flow
The UI communicates with the backend through an NGINX Gateway, which serves as the load balancer and routes user traffic to the appropriate backend services.


Application Containers(Docker)
Core Services
These services are containerized for modular scalability, improving reliability and simplifying maintenance:

Event Listing Service: Manages climate strike events, including date, location, and status.
User Authentication Service: Handles user registration, login, and session management.
User Management Service: Manages user rofiles and tracks participation history.
Volunteer Coordination Service: Enables users to sign up for volunteer roles in upcoming events.

AI Services
Smart Waste Management Advisor: An AI-driven system designed to assist users in making sustainable waste management decisions, integrated with the platform for enhanced user experience.
https://huggingface.co/spaces/ELiOkine/EcoTrash 

Data Layer
MySQL Database: Stores user data, event details, participation logs, and educational content.

Monitoring & Analytics
Prometheus: Collects performance metrics from backend services for system health monitoring and troubleshooting.
Grafana Dashboard: Visualizes system metrics, including traffic patterns and event participation rates, for better performance monitoring.

Architecture 
We are implementing a microservices architecture.By adopting a microservices architecture, EcoMomentum can achieve a more robust, scalable, and agile system, aligning with modern development practices.
Adopting a microservices architecture for EcoMomentum offers several key advantages:
Scalability: Microservices enable independent scaling of components based on demand, optimizing resource utilization and enhancing performance.
Fault Isolation: Isolated services ensure that failures in one component do not disrupt the entire system, improving overall reliability.
Faster Development and Deployment: Independent services allow for parallel development and quicker deployment cycles, accelerating time-to-market.
Flexibility in Technology Choices: Teams can select the most suitable technologies for each service, enhancing efficiency and performance.

A picture of architecture  
![image](https://github.com/user-attachments/assets/a1dabe68-6dd6-450a-9a7c-7c7ab8aadc28)

Work Flow 
1. User Registration & Login
Users register or log into the platform.
Upon login, they are directed to a personalized dashboard displaying upcoming events and relevant educational content.
2. Event Browsing
Users browse available climate strike events using the Event Listing Service.
Events can be filtered by location, date, and type (e.g., global strike, local protest).
3. Event Participation
Users can sign up for events, both local and global.
Notifications, reminders, and updates are sent to users about the events they’re participating in.
4. Tracking Impact
Users can track their personal impact through the platform, including events attended and campaigns supported.
The platform aggregates collective community impact, such as the number of events organized and resources shared.


Since we will employ agile methodology this is some user stories (UML diagrams)
Activity diagram 
![image](https://github.com/user-attachments/assets/29c28c0b-8dae-4ea8-9f9f-b108a9512c61)
Sequence diagram
![image](https://github.com/user-attachments/assets/bd113415-791b-4d97-9df2-c78c1c78279d)
Class diagram 
![image](https://github.com/user-attachments/assets/d33cea47-7d94-46d9-9e80-f30f617a8718)


MILESTONE 2 
We have effectively utilized GitHub's project management tools to streamline our EcoMomentum project. By creating a public repository under the Ashesi CSIS GitHub account, we ensured transparency and collaboration. All team members were added as collaborators, granting them the necessary permissions to contribute to the project. We organized our workflow by creating issues for tasks, assigning them to specific team members, and setting realistic deadlines to ensure timely completion. This approach has enhanced our team's efficiency and accountability throughout the project's development.
Below is a screenshot of Continuous Development 
![Continuous development](https://github.com/user-attachments/assets/71b61743-a18f-45fb-8063-5573fb3bded6)

MILESTONE (Containerization and orchestration tools)
We have implemented Docker containers to enhance our continuous deployment (CD) pipeline for the EcoMomentum project. By containerizing our application, we ensure consistency across development, testing, staging, and production environments, facilitating seamless deployment processes. Docker's containerization allows us to package the application along with all its dependencies, ensuring that it operates uniformly across different environments

Below are the screenshots
![containerization](https://github.com/user-attachments/assets/6371b8df-e67b-4fa1-ae95-7ed2147d009a)
![Containerization2 ](https://github.com/user-attachments/assets/67268d4b-4966-491b-8193-5fbc80a62803)
![docker container ](https://github.com/user-attachments/assets/033313bb-c14a-4a74-b8cc-37e69548e17a)


CONTAINERISATION AND ORCHESTRATION - DOCKER 

WHY DOCKER AND NOT KUBERNETES 

1.Straightforward to set up and ideal for smaller projects( we had few containers to manage ).

2.Docker was simpler and quick to implement compared to kubernetes.

3.Docker consumes less resources and is lightweight 

4.We felt as a team that it was easier to manage within the timeframe  .


Continuos feedback 
We used Datadog ,puppet.

Some pictures of our website 
![image](https://github.com/user-attachments/assets/a3f37356-714f-4aef-9ab7-0b7de75d893b)

![WhatsApp Image 2024-12-12 at 10 21 56_762646ea](https://github.com/user-attachments/assets/3e08cac3-2fa9-4f66-8176-f5fa1303ca66)



![WhatsApp Image 2024-12-12 at 10 23 59_aa161fd4](https://github.com/user-attachments/assets/e693b28d-ec9e-42d5-920d-84929d7d0068)

![WhatsApp Image 2024-12-12 at 10 26 00_82eb9f42](https://github.com/user-attachments/assets/0e4c85a2-6c10-4990-9b5a-55844ba6fa2f)

![WhatsApp Image 2024-12-12 at 10 27 07_c2489cd1](https://github.com/user-attachments/assets/160e58b3-f495-454a-8566-87aff691ff01)
![WhatsApp Image 2024-12-12 at 10 31 38_73fd015b](https://github.com/user-attachments/assets/647e20f1-5a78-478a-8287-6c87d340fd5a)









