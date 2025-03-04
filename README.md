## Setup instructions

To run the project follow these steps:

- **Clone the project.**
- **Install packages by running:**
```bash
composer install
```
- **Create .env file with key**
```bash
cp .env.example .env
php artisan key:generate
```

- **For the database, add the configuration to .env file. then run**
```bash
php artisan migrate
```

or download the database file and import it in your phpmyadmin from the [link](https://drive.google.com/file/d/1bSglNxfpVFm5gS1NVHcwgq05RNXV-Tq5/view?usp=sharing)

- **To test the project, you can create your own API requests or you can use this [postman collection](https://www.postman.com/solar-crater-156104/astudio-orders-approval/overview).**


## Usage
To use the project APIs and features you must:

- **In postman collection, add your localhost URL for this project into the environment variable called 'url'**
- **After creating some items, you can use the order APIs**


## License

This code is licensed under the [MIT license](https://opensource.org/licenses/MIT).
