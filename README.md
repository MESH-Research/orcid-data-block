# WordPress Plugin for ORCiD Data

## Description

The plugin pulls data from [ORCiD](http://orcid.org) based on the user's ORCiD ID.
Any facet of the user's ORCiD can be added to WP pages or posts using WP shortcodes or as blocks
using the Gutenberg block editor.

IMPORTANT: This plugin requires the XSL php extension to be installed.

### Dedication

This project continues the work originally started by Amaresh Joshi, a PhD student in the
Linguistics Program at MSU who passed in 2022.  Amaresh was a valued colleague, scholar
and collaborator.  This work and its continued development are dedicated to Amaresh's
memory.

## Development Prerequisites

* git
* npm
* Docker or Docker Desktop

## Installation for Development

1. Clone this repository from GitHub onto your computer
2. Open a command-line and navigate to the directory of the cloned repository
3. Ensure npm has all installed dependencies and run:
    * `npm i`
4. Run the project's build script:
    * `npm run build`
5. Run this command to copy the environment variables file:
    * `cp .env.sample .env`
6. Run this command to copy the Docker configuration file:
    * `cp docker-compose.yml.sample docker-compose.yml`
    * Optionally, uncomment the code in `docker-compose.yml` to enable a persistent database
7. If using Docker Desktop, open it
8. Run this command `docker-compose up --detach`

## WordPress Debugging

Edit `wp-config.php` to include

```php
//define( 'WP_DEBUG', !!getenv_docker('WORDPRESS_DEBUG', '') );
define( 'WP_DEBUG', true);
//
define( 'WP_DEBUG_LOG', true );
define( 'SCRIPT_DEBUG', true );
define( 'SAVEQUERIES', true );
define( 'WP_DEBUG_DISPLAY', true );
```

## Block Editing

The plugin will create an ORCiD block.

## Shortcodes

Shortcodes used with the ORCiD plugin take the form `[orcid-data section="section_name"]`
where section_name is one of the following:

* `header`
* `personal`
* `education`
* `employment`
* `works`
* `fundings`
* `peer_reviews`
* `invited_positions`
* `memberships`
* `qualifications`
* `research_resources`
* `services`

In addition, when the section_name is `works` two additional optional attributes can be specified:

`[orcid-data section="works" works_type="type of work" works_start_year="published year start"].`

Both attributes are optional with default values.

* `works_type` = include only works of that type (default is `all`)
* `works_start_year` = include only works with a published year greater than or equal to
  the start year (default is `1900`)

[List of available work types](https://github.com/ORCID/orcid-model/blob/master/src/main/java/org/orcid/jaxb/model/common/WorkType.java)
