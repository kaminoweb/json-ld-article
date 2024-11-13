# Article JSON-LD Generator

**Contributors:** KAMINOWEB INC  
**Tags:** SEO, JSON-LD, schema, blog post, structured data  
**Requires at least:** 5.0  
**Tested up to:** 6.7  
**Stable tag:** 1.1  
**License:** GNU General Public License v3.0  
**License URI:** https://www.gnu.org/licenses/gpl-3.0.html

Automatically generates a **JSON-LD** schema for blog posts and saves it to a custom field for better SEO.

## Description

The **Article JSON-LD Generator** plugin for WordPress automatically generates a **JSON-LD** schema for each blog post and stores it in a custom field for improved SEO. By adding structured data, the plugin helps search engines better understand the content of your posts, potentially improving search rankings.

### Key Features:

- **Automatic JSON-LD Schema**: Generates structured data for blog posts automatically.
- **Custom Field Storage**: Saves the generated JSON-LD schema in a custom field (`article-JSON-LD`).
- **Schema Details**: Includes key details like post title, featured image, author, dates, and description.
- **Optimized for SEO**: Helps improve SEO by providing structured data in the form of JSON-LD.
- **Easy Integration**: The plugin works automatically when a post is saved.

## Installation

### 1. Upload the Plugin:

- Download the **Article JSON-LD Generator** plugin from GitHub.
- Upload the `article-json-ld-generator` folder to the `/wp-content/plugins/` directory on your WordPress installation.

### 2. Activate the Plugin:

- Go to the **Plugins** menu in WordPress and click **Activate** under the **Article JSON-LD Generator** plugin.

### 3. Using the Plugin:

- The plugin automatically adds JSON-LD schema to each post when it is saved.
- The schema is stored in a custom field called `article-JSON-LD`. You can use this custom field in your theme or with other plugins to display or use the JSON-LD data.

## Frequently Asked Questions

### How does the plugin generate the JSON-LD schema?

The plugin automatically generates a JSON-LD schema for blog posts by gathering information such as the post title, URL, publication date, author, featured image, and custom descriptions. It then stores this schema in a custom field for easy access.

### Can I edit the generated JSON-LD data?

The plugin generates the JSON-LD data based on the available information from your posts, but you can customize or extend it using hooks or by manually editing the custom field `article-JSON-LD`.

### Does the plugin require an API key or third-party service?

No, the plugin does not require an API key or external services. It generates the JSON-LD schema based on data already available in WordPress.

### What kind of structured data does the plugin generate?

The plugin generates **BlogPosting** schema type, including:
- Title (headline)
- Featured image (image)
- Author (name)
- Publication date
- Modification date
- Post URL
- Description

## Changelog

### 1.1
- Updated version for better compatibility with WordPress 6.x.
- Minor fixes to the description handling.

### 1.0
- Initial release of the plugin.

