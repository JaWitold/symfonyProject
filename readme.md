# Symfony Project Template

This is a template for a Symfony project with Docker Compose setup, including NGINX, PHP, and PostgreSQL containers.

## Getting Started

To get started with this project template, follow the steps below:

### Prerequisites

- Docker and Docker Compose should be installed on your machine. If not, please refer to the Docker documentation for
  installation instructions.

### Installation

1. Clone the repository:

   ```bash
   git clone git@github.com:JaWitold/symfonyProject.git
   ```

2. Navigate to the project root directory:

   ```bash
   cd symfonyProject
   ```

3. Copy the example environment file and modify it according to your needs:

   ```bash
   cp .env.example .env
   ```

   Make sure to update any necessary environment variables in the `.env` file.

4. Build and start the Docker containers:

   ```bash
   docker-compose up -d
   ```

   This will start the NGINX, PHP, and PostgreSQL containers defined in the `docker-compose.yml` file.

5. Open your browser and access the health endpoint:

   ```
   http://localhost:8080/health
   ```

   If everything is set up correctly, you should see a response indicating the health of the application.

## Running Tests
Before submitting a merge request, please ensure that the project passes the GitHub CI/CD pipeline. The following tests are performed:

- **PHP Code Sniffer**: Checks the code against coding standards to ensure consistency.

   ``` bash
   docker-compose exec -t php sh -c "XDEBUG_MODE=off php vendor/bin/phpcs"
   ```
- **PHPStan**: Performs static analysis to identify potential errors and improve code quality.

   ``` bash
   docker-compose exec -t php sh -c "XDEBUG_MODE=off php vendor/bin/phpstan analyse"
   ```
- **PHPUnit Tests**: Runs the unit tests to ensure the functionality of the application.

   ``` bash
   docker-compose exec -t php sh -c "XDEBUG_MODE=off php vendor/bin/phpunit"
   ```

- **Code Coverage**: Runs the unit tests to ensure the coverage of the application.

   ``` bash
   docker-compose exec -t php sh -c "XDEBUG_MODE=coverage php vendor/bin/phpunit --coverage-text"
   ```
Make sure all tests pass without any errors before submitting your merge request.

## Usage

You can start building your Symfony application based on this template. The project structure follows standard Symfony
conventions.

- The source code is located in the `src/` directory.
- The tests are located in the `tests/` directory.
- The NGINX configuration can be found in `docker/nginx/default.conf`.
- The PHP configuration can be modified in `docker/php/`.

Feel free to customize the project according to your specific requirements.

## Contributing

Contributions are welcome! If you have any suggestions, improvements, or bug fixes, please open an issue or submit a
pull request.

## License

This project is licensed under the [MIT License](LICENSE).
