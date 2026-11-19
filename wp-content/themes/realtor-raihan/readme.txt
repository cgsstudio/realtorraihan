=== Realtor Raihan ===
Contributors: Realtor Raihan
Requires at least: WordPress 6.0
Tested up to: 6.7
Requires PHP: 7.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A custom WordPress theme for Raihan Shaikh, property consultant in Business Bay, Dubai.

== What this theme is ==

This is a purpose-built theme, not a page builder. The design, the fonts, the
photos and the copy that were approved are all inside the theme, and the client
can change every piece of text and every photo from the normal WordPress
dashboard.

== Install ==

1. WordPress dashboard > Appearance > Themes > Add New > Upload Theme.
2. Choose realtor-raihan.zip and click Install, then Activate.
3. On activation the theme creates the pages it needs (Home, About, Blog,
   Contact) and sets Home as the front page and Blog as the posts page.
4. Go to Tools > Realtor Raihan demo and click "Import demo articles" to load
   the six approved blog articles with their images.
5. Check Settings > Reading: Front page shows "Home", Posts page shows "Blog".

== Where to edit what ==

* Home Page (left menu)
  Every heading, paragraph, button label, stat, service card, testimonial,
  FAQ and section on/off switch. Clear a field to go back to the approved copy.

* Home Page > About page
  The whole About page: banner title, both paragraphs, pull quote, the four
  points, photo badge and the closing call to action.

* Appearance > Customize > Realtor Raihan - Site settings
  1. Brand and logo (name, sub line, header mark, footer lockup)
  2. Contact details (phone, WhatsApp, email, area, agency, social links)
  3. Header buttons (the small label, the gold button text and link)
  4. Footer (disclaimer, copyright line, service locations list)
  5. Home page search description

* Posts
  Add or edit blog articles. The featured image becomes the article's hero.

* Pages
  Add a new page for anything else (Privacy Policy, Terms). It renders inside
  the same header and footer.

* Appearance > Menus
  Create a menu and assign it to "Primary menu (header)" to replace the default
  Home / About / Blog / Contact menu. Until then the default menu is used.

== Contact form and newsletter ==

The contact form and the newsletter box post to WordPress itself; no plugin is
needed. Each enquiry is:

  1. emailed to the address in Customizer > Contact details, and
  2. stored under Home Page > Enquiries, with an "Emailed" column.

If the host has not enabled PHP mail yet, the message is still stored and the
Emailed column shows a dash. Enabling PHP mail, or installing any SMTP plugin,
is enough to start delivering them. Newsletter signups are stored in the
"rr_subscribers" option and emailed to the same address.

== Photos ==

All photos ship inside the theme (assets/img) so the site works straight away.
To swap one, upload your own under Media, copy its URL, and paste it into the
matching field (Home Page, About page or the Customizer). Bare file names such
as "skyline-dusk-wide.webp" also work and point at the bundled image.

== Type ==

Vend Sans (display) and Zalando Sans (body) are embedded in the theme, so no
Google Fonts request is made and nothing depends on a third party service.
