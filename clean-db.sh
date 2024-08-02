#!/bin/bash

# Check if the WordPress database has tables
if wp db tables >/dev/null 2>&1; then
    # The WordPress database has tables

    # Make a WordPress database clean command
    wp db clean --yes
else
    # The WordPress database does not have tables
    echo "The WordPress database does not have any tables. Nothing to clean."
fi
