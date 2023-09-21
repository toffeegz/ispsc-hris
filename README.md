<p align="center"><img src="https://i.im.ge/2022/04/25/lvswsy.png" width="400"></p>


# Getting Started
## LARAVEL API
This system is built using the Laravel PHP framework to create a robust and efficient HRIS.

## About ISPSC HRIS

Ilocos Sur Polytechnic State College HRIS is a comprehensive Human Resource Information System designed to streamline HR processes mainly focuses on performance management and enhance employee management.

- **User Login**: Provide secure access to authorized users.
- **Dashboard**:
  - **Overview**: Present key HR metrics and data.
  - **Data Visualization**: Display attendance patterns and habitual tardiness trends.
- **Employee Management**:
  - **Profiles**: Manage employee information and details.
  - **Training Records**: Track employee training and development.
- **Timekeeping**:
  - **Attendance Data Import**: Import attendance data for analysis.
  - **Leave Records**: Monitor and manage leave requests.
- **Performance Management**:
  - **Performance Review Cycles**: Schedule and manage performance reviews.
  - **Generate IPCR**: Create Individual Performance Commitment and Review documents.
  - **Historical Records**: Maintain historical performance data.
  - **Performance Reports**: Generate performance reports for analysis.
- **HR Analytics and Reports**:
  - **Data Analysis**: Analyze attendance data to compute habitual tardiness.
  - **Report Generation**: Create HR reports.
  - **Data Visualization**: Visualize HR data for insights.
- **Admin Settings**:
  - **User Management**: Administer user accounts.
  - **Role Management**: Configure user roles and permissions.
  - **Audit Logs**: Track system activities.
- **System Settings**:
  - **IPCR Evaluation Criteria**: Define evaluation criteria categories and sub-categories.

## Installation

Follow these steps to set up ISPSC HRIS locally:

1. Clone the repository:

    git clone git@github.com:toffeegz/ispsc-hris.git

2. Navigate to the project directory:

    cd payroll-management-system

3. Install project dependencies using Composer:

    composer install

4. Run database migrations: (**Set the database connection in .env before migrating**)

    php artisan migrate

5. Seed the database with initial data:

    php artisan migrate

6. Configure your email credentials in the `.env` file.

    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=
    MAIL_PASSWORD=
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=
    MAIL_FROM_NAME="${APP_NAME}"

7. Start the local development server:

    php artisan serve
    
You can now access the server at http://localhost:8000

## IMPORTANT
Make sure to run queue jobs and scheduler for system to generate weekly and semimonthly payroll periods, employee payslip.

## About the Developer

Gezryl Beato Gallego (toffeegz) is a Full Stack Developer based in Philippines. 
- Laravel
- Vue.JS
- ReactJS
- Typescript
- Google Apps Script
- Google API
- RESTful API
- Tailwind
- Livewire
- Bootstrap
- JQuery and Ajax

## Visit my Profile
- [LinkedIn](https://www.linkedin.com/in/gezryl-clariz-beato-078312139/)
- [Github](https://github.com/toffeegz)
- [Facebook](https://www.facebook.com/toffeegz/)
