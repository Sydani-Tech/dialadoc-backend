# Dial-a-Doc Project API Endpoint Server

This project provides an API endpoint server for the Dial-a-Doc application. Follow the instructions below to set up the project on your local machine.

## Minimum Requirements

Ensure your system meets the following requirements:
- PHP 8.2 or higher
- Composer
- MySQL

## Installation

1. **Clone the repository:**
    ```bash
    git clone <repository-url>
    ```
2. **Navigate to the project directory:**
    ```bash
    cd <project-folder>
    ```
3. **Install dependencies:**
    ```bash
    composer install
    ```
4. **Set up environment variables:**
    - Rename `.example.env` to `.env`:
        ```bash
        cp .env.example .env
        ```
    - Update the `.env` file with your database credentials.

5. **Create the database:**
    - Use the database name specified in the `.env` file and create the database in MySQL.
    
6. **Run database migrations:**
    ```bash
    php artisan migrate
    ```

## Development Workflow

1. **Create a new branch for your feature:**
    ```bash
    git checkout -b <feature-branch-name>
    ```
2. **Make your changes and commit them:**
    ```bash
    git add .
    git commit -m "Description of your changes"
    ```
3. **Push your changes to the repository:**
    ```bash
    git push origin <feature-branch-name>
    ```

---

Follow these instructions to ensure a smooth setup and development process for the Dial-a-Doc API endpoint server. If you encounter any issues, refer to the Laravel documentation or seek help from the team.
