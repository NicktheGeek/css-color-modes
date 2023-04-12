# Thincrust 🍕🤏

**A lightweight starter theme for Reaktiv**

Staging Site: boilerplate.reaktivdev.com

### Features

#### MU Plugins

• Reaktiv SSO - Simplify login without needing to create a user. Just use your Reaktiv email.

### Installation & Setup

After cloning the project into your `wp-content` directory, you will want to change a few things:

- `.phpcs.xml.dist` - Update the text_domain and prefixes so they fit the name of the project.
- `themes/thincrust/theme.json` - Update with your project's colors, font families, font sizes, and general styling properties.
- In the root directory, run `composer install`, `nvm use`, `npm install`, and `npm run build`. This will build the theme, and the **thincrust-blocks** plugin, autoloading the relevant PHP Namespaces, so, in theory, you don't even need to turn on the plugin to get the blocks to turn on.

#### PHP

In the spirit of extensibility, the root `functions.php` is meant to be bare, with the functionality broken out into `inc/functions-*.php` files. Similarly, the templates utilize `do_action()` to bring in the content. For example, `header.php` has `do_action( 'thincrust_header' );`, with the relevant functions living in `/inc/functions_header.php`. There you will find the title, main menu, and mobile menu.

#### SCSS

- `themes/thincrust/assets/src/styles/global/variable-library.scss` - Using the CSS Variables that WordPress creates based on the theme.json variables, here is where you have a variety of properties to use in your components.
- `themes/thincrust/assets/src/styles/global` - SCSS for header, mobile menu, footer, entry content (the block area).
- `themes/thincrust/assets/src/styles/components` - SCSS For Blocks, Patterns, and other reusable components that are part of Post/Page content. Each of these files define more variables to use for altering the elements.

#### Mixins

##### Media Queries

    @include mq("sm") {
    	.element { max-width:100%; }
    }

##### Entry Padding

    `@include entry-padding;`

    A commonly used set of rules to define a base layout for a an element that spans the width of the available space, minus a outside horizontal space to provide visual gap between the element and the edge of the browser window.

    For example, this is used to define the layout for an unaligned block element.

### Variable Naming Conventions

TBD
