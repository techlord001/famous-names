# Famous Names

**Famous Names** is a Laravel-based project that allows users to view, update, and delete the records of famous "personalities". Each record consists of a name and geographic coordinates (latitude and longitude) displayed in an interactive Google Map.

### Features
- **View All Famous Names:** A list of all names stored in a local JSON file and cached for performance.
- **Edit a Name:** Allows modification of the existing names. Also has validation to ensure data integrity.
- **Delete a Name:** Remove a name from the list.
- **Interactive Google Map:** View the geographic location associated with each famous name.

### How to Build and Run the Project

1. **Clone the Repository**
    ```sh
    git clone https://github.com/techlord001/famous-names.git
    cd famous-names
    ```

2. **Install Composer Dependencies**
    ```sh
    composer install
    ```

3. **Install NPM Dependencies**
    ```sh
    npm install
    ```

4. **Build Assets**
    ```sh
    npm run build
    ```

5. **Configure .env File**

    Copy `.env.example` to `.env` and fill in your database and other environment-specific details. Obtain a Google Maps API key and add it to the `.env` file.

8. **Start the Local Development Server**
    ```sh
    npm run dev
    php artisan serve
    ```

    Visit [http://localhost:8000/famous-names](http://localhost:8000/famous-names) in your browser.

### How to Run Tests

You can run the provided tests with PHPUnit using the following command:

```sh
vendor/bin/phpunit
```

### Technologies Used
- Laravel
- Google Maps JavaScript API
- Bootstrap

### Usage

Visit [http://localhost:8000/famous-names](http://localhost:8000/famous-names) to view the list of famous names. Each name is associated with geographic coordinates displayed interactively using Google Maps.

### Code Structure Explanation

#### FamousNamesService Class

The `FamousNamesService` class is crucial in the application as it's responsible for retrieving, updating, and deleting famous names. It works with Cache and Storage contracts to ensure flexibility and adherence to SOLID principles, particularly the Dependency Inversion Principle. 

This class utilizes a cache repository to temporarily store the names for faster retrieval and a storage repository to fetch the data from a JSON file. It ensures that if the data is not available in the cache, it fetches it from the JSON file and then stores it in the cache for subsequent accesses. 

Methods include:
- `getNames()`: Retrieves the list of famous names from the cache or the JSON file if not cached.
- `updateName($id, $updatedData)`: Updates a particular name record identified by its ID with the provided data.
- `deleteName(int $id)`: Removes a specific name record from the list.

This class is injected into the `FamousNamesController`, which is responsible for handling HTTP requests related to the famous names, ensuring a separation of concerns and making the codebase easier to manage and test.
