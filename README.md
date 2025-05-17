# Laravel Leaderboard Activity Tracker 

This Laravel-based project displays a leaderboard of users who earn points by completing daily physical activities such as walking and running.

## Features

- +20 points for every logged activity (no limit per day)
- Users ranked based on total points
- Leaderboard filters:
  - Daily (today only)
  - Monthly (current month)
  - Yearly (current year)
- Search by user ID
- Re-calculate leaderboard to refresh ranks
- Ranks are stored in the database (not calculated on-the-fly)

## Prerequisites
Before you begin, make sure you have the following installed on your system:

- [Composer](https://getcomposer.org/)

## Installation

1. **Clone the repository to your local machine:**
    ```bash
    git clone https://github.com/Asad9299/leaderboard-activity-tracker.git
    ```

2. **Navigate to the project directory:**
    ```bash
    cd leaderboard-activity-tracker
    ```

3. **Install Composer dependencies:**
    ```bash
    composer install
    ```
4. **Copy the example environment file:**
    ```bash
    cp .env.example .env
    ```

5. **Configure your `.env` file with appropriate database and other settings.**

6. **Generate application key:**
    ```bash
    php artisan key:generate
    php artisan migrate --seed
    ```
7. **Run the console command first to calculate the leaderboard:**
   ```bash
    php artisan leaderboard:calculate
    ```
    
## Running the Application

1. **Start the development server:**
    ```bash
    php artisan serve
    ```

2. **Visit [http://localhost:8000/leaderboard](http://localhost:8000/leaderboard) in your web browser.**
