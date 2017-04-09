# Mailtrain WordPress Plugin

## Features

This Plugin adds a shortcode and widget for embedding Mailtrian subscription forms to your WordPress installation.

#### Shortcode

```
[mailtrain-subscription-widget url="http://domain/subscription/Byf44R-og" fallback-text="Subscribe to our list"]
```
- `url`: The URL of your Mailtrain subscription form (required)
- `fallback-text`: Defaults to "Subscribe to our list" (optional)

#### Widget

Same parameters as the shortcode plus an optional widget title.

## Installation

1. Download the repository .zip file: [mailtrain-wordpress-plugin.zip](https://github.com/mailtrain-org/mailtrain-wordpress-plugin/archive/master.zip)
2. In WordPress, nagitate to Plugins → Add New, then upload the zip file and activate the plugin
3. Install the [GitHub Updater](https://github.com/afragen/github-updater) for automatic updates (optional)
4. [Enable cross-origin resource sharing](https://github.com/Mailtrain-org/mailtrain#subscription-widget) in your Mailtrain `config` file and whitelist your site

## Contributing

Contributions are welcome from everyone.

## License

This plugin is Free Software, released and licensed under the **GPL-V3.0**
