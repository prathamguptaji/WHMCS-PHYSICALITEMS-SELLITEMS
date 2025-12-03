Physical Goods & Shipping Module for WHMCS
- Made By PrathamGuptaji

Version: 1.1.0

This module allows you to sell physical products (Games, CDs, Hardware, Merch) using WHMCS. It replaces the standard hosting control panel with a shipping dashboard, allowing clients to track their orders.

INSTALLATION

Create Directory Structure:
Access your WHMCS installation via FTP or File Manager and create the following folders:

/modules/servers/physical_shipping/
/modules/servers/physical_shipping/templates/

Upload Files:

Upload physical_shipping.php to:
/modules/servers/physical_shipping/

Upload overview.tpl to:
/modules/servers/physical_shipping/templates/

CONFIGURATION (ADMIN AREA)

Log in to your WHMCS Admin Area.

Navigate to System Settings > Products/Services.

Create a new Product Group (e.g., "Physical Games") and a new Product (e.g., "Elden Ring CD").

Module Settings Tab:

Module Name: Select "Physical Goods & Shipping" from the dropdown.

Shipping Carrier: Select your default carrier (DHL, FedEx, etc.).

Tracking URL Base: (Optional) Leave empty to use default carrier links.

Show Address: Check "Yes" to display the shipping address to the client.

Note: Do NOT enable "Automatically setup the product". You likely want to manually pack the item first.

TRACKING NUMBER SETUP (CRITICAL)

The module needs a place to store the tracking number. You must create a custom field.

While editing the Product, click the Custom Fields tab.

Click Add New Custom Field.

Field Name: You can name this anything containing "Tracking", "Ref", "Ship", or "Consignment".

Recommended: Tracking Number or Ref Number

Field Type: Text Box

Admin Only: [x] CHECK THIS BOX.

Why? This prevents the customer from editing the tracking number themselves.

Show on Order Form: Uncheck this (unless you want them to input a reference).

Save Changes.

HOW TO PROCESS AN ORDER

When a client buys a physical product:

Status: The order will arrive as "Pending".

Fulfillment: You physically pack the item and generate a label from your courier.

Enter Tracking:

Go to the Client's Profile in WHMCS Admin.

Click the Products/Services tab.

Scroll down to the Custom Fields section.

Paste the tracking ID into the Tracking Number (or Ref Number) box.

Click Save Changes.

Mark as Shipped:

On the same page, scroll down to "Module Commands".

Click the Create button.

What this does:

Changes status to Active.

Sends the "Welcome Email" (You should rename this email template to "Order Shipped").

Updates the Client Area dashboard to show the "Shipped" step.

CUSTOMIZING THE CLIENT AREA

To change the look of the dashboard (icons, colors, text):

Edit /modules/servers/physical_shipping/templates/overview.tpl

To change the tracking logic:

Edit /modules/servers/physical_shipping/physical_shipping.php