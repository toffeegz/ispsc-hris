<p align="center"><img src="https://i.im.ge/2022/04/25/lvswsy.png" width="400"></p>


# Getting Started
## LARAVEL API
This system is built using the Laravel PHP framework to create a robust and efficient HRIS.

## About ISPSC HRIS

Ilocos Sur Polytechnic State College HRIS is a comprehensive Human Resource Information System designed to streamline HR processes mainly focuses on performance management and enhance employee management.

- **User Login**: Provide secure access to authorized users.
- **Dashboard**:
  - **Overview**: Present key HR metrics and data.
  - **Data Visualization**: Display attendance patterns, habitual tardiness trends, IPCR and OPCR Summary.
- **Employee Management**:
  - **Profiles**: Manage employee information and details.
  - **Training Records**: Track employee training and development.
  - **Awards/Accomplishments**: Track employee training and development.
- **Timekeeping**:
  - **Attendance Data Import**: Import attendance data for analysis.
  - **Leave Records**: Monitor and manage leave.
- **Performance Management**:
  - **IPCR**: Create Individual Performance Commitment.
  - **OPCR**: View Overall Performance Commitment.
- **Admin Settings**:
  - **User Management**: Administer user accounts.
- **System Settings**:
  - **Department**: Define departments and its employee head.
  - **Leave Type**: Define leave types.
  - **Position**: Define positions.
  - **Employment Status**: Define employment statuses.

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

## About the Developer

Gezryl Beato Gallego (toffeegz) is a Full Stack Developer based in Philippines. 
- Laravel
- Vue.JS
- RESTful API
- Tailwind
- Livewire
- Bootstrap
- JQuery and Ajax

## Visit my Profile
- [LinkedIn](https://www.linkedin.com/in/gezryl-clariz-beato-078312139/)
- [Github](https://github.com/toffeegz)
- [Facebook](https://www.facebook.com/toffeegz/)
