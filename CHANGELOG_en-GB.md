# 1.2.0
- Privacy: "When to load the container" now defaults to "Only after consent". On update the setting is set once to "Only after consent" in all sales channels and globally
- Enhanced conversions: email, phone, first and last name are normalised and SHA-256-hashed in the shop (`sha256_email_address`, `sha256_phone_number`, `address.sha256_first_name`, `address.sha256_last_name`); `ecommerce.user_email` removed. Update GTM variables to the new paths
- Config JSON in the page head escapes `< > & ' "`

# 1.1.1
- New plugin icon in Nova style
- Repository renamed to SW6-Nova-Tag-Manager

# 1.1.0
- New: customer data for Google Ads enhanced conversions on purchase (`ecommerce.user_email`, `user_data`), only with marketing consent; off by default
- GTM templates in `vorlagen/`

# 1.0.1
- Cookie dialog: if the "Statistics" or "Marketing" group is missing (e.g. other plugins still use the legacy cookie provider), it is created – otherwise consent could never be granted

# 1.0.0
- First release: Google Tag Manager per sales channel with GA4 e-commerce data layer
- Consent Mode v2 via the Shopware cookie banner or an external consent tool
- Product lists, sliders, cross-selling, recently viewed and search window are tracked
- Clicks, cart (incl. quantity changes), checkout, purchase (once per order), login, sign-up, search
- Google Ads remarketing (google_tag_params), optional server-side tagging
