# WordPress-Custom-Endpoint-Plugin:

Custom API Endpoint Plugin creates a custom endpoint in WordPress to fetch data from an external API and presents this data as an HTML table that users can view. Additionally, it allows users to view details of any specific user.

# Features:

Create a custom endpoint in WordPress.
Fetch data from an external API and generate an HTML table.
Fetch and display details of any specific user via AJAX.

# Installation:

Upload this plugin to the wp-content/plugins/ directory of your WordPress installation.
Activate the plugin through the 'Plugins' menu in WordPress.

# Usage:

Once activated, you can access the custom endpoint at http://example.com/custom-api-endpoint. Here, you will see a table containing data fetched from the external API.
Clicking on any user in the table will trigger an AJAX request to fetch and display details of that user.

# Development:

If you want to contribute to this project, you can follow these steps:

# Clone this project:

git clone https://github.com/batuhanyigitt/Custom-API-Endpoint-Plugin

Navigate to the project directory: cd Custom-API-Endpoint-Plugin

Install the necessary dependencies: composer install

Concatenate and minify JavaScript files: uglifyjs custom-api-endpoint-script.js -o custom-api-endpoint-script.min.js

Start development and track your changes.

Contributing

You can submit your feedback or bug reports through the Issues section.
You can contribute to the project by sending a pull request.
