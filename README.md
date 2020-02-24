# artwork-conversion
A communication tool for customer and admin - to convert an artwork into website or software.

# Installation
* Checkout the project in _/home/[USER]/subdomains/_ which is a location outside of a default public_html.

Set the following subdirectories into your subdomains:
* admin.example.com => *admin/public_html*
* api.example.com => *api/public_html*
* assets.example.com => *assets/public_html*
* customers.example.com => *customers/public_html*
* developer.example.com => *developer/public_html*
* hooks.example.com => *hooks/public_html*
* kpi.example.com => *kpi/public_html*
* www.example.com => *www/public_html*

Copy sample.ini into configs.ini. And, edit [configs.ini](configs.ini).

## Database
/store/database/slicing.db

## CHMOD Permissions
* chmod -R 777 store/

# Help Wanted
* Please review [todo.md](todo.md) to sort them out.
* Also, there are **@todo** tags within the source code.
