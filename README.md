=== ORCID Data Block ===
Contributors: adamsbmsu
Donate link: https://meshresearch.net/
Tags: ORCID
Requires at least: 5.9
Tested up to: 6.4.3
Requires PHP: 8.0
Stable Tag: 1.0.0
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Display ORCID profile data using a WordPress block or shortcode.

# WordPress Plugin for displaying ORCID Data

## Description

This plugin pulls data from [ORCID](http://orcid.org) based on the user's ORCID iD.
Any facet of the user's ORCID can be added to WP pages or posts using WP shortcodes or as blocks
using the Gutenberg block editor.

IMPORTANT: This plugin requires the XSL php extension to be installed.

## Dedication

This project continues the work originally started by Amaresh Joshi, a PhD student in the
Linguistics Program at MSU, and member of the MESH Research team who passed in 2022.  Amaresh was a valued colleague, scholar
and collaborator.  This work and its continued development are dedicated to Amaresh's
memory.

## Block Editing

The plugin will create an ORCID block.

## Shortcodes

Shortcodes used with the ORCID plugin take the form `[orcid-data section="section_name"]`
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
