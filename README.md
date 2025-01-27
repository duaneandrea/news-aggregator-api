### **Backend (Laravel) Docker Setup**

#### **Step-by-Step Instructions:**

1. **Ensure all necessary files are created:**
   - `Dockerfile` (for Laravel project)
   - `.dockerignore`
   - `docker-compose.yml`
   - `nginx.conf`

2. **Build and Run the Backend with Docker:**

   From the root directory of your Laravel project, follow these steps:

   1. **Build the Docker image:**

      Run the following command in the terminal:

      ```bash
      docker build -t laravel-app .
      ```

   2. **Run the container:**

      You can start the container with the following command:

      ```bash
      docker run -p 8000:9000 laravel-app
      ```

      This will expose port 9000 of the container to port 8000 on your machine. You can now access the Laravel app at `http://localhost:8000`.

   **Alternatively**, if you're using Docker Compose:

   1. **Run using Docker Compose:**

      ```bash
      docker-compose up --build
      ```

      This will build and start the containers (including Nginx, Laravel app, and MySQL) as defined in the `docker-compose.yml` file.

   2. **Access the application:**

      After running the command, the Laravel app should be accessible via `http://localhost:8080` (as mapped in the `docker-compose.yml` for Nginx). The database will be available at `localhost:3306` (as mapped for MySQL).