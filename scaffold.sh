#!/bin/bash

# Function to convert string to lowercase with hyphens
to_hyphenated() {
    echo "$1" | tr '[:upper:]' '[:lower:]' | tr ' ' '-'
}

# Function to convert string to lowercase with underscores
to_underscored() {
    echo "$1" | tr '[:upper:]' '[:lower:]' | tr ' ' '_'
}

# Prompt for project details
read -p "Enter project name: " project_name
read -p "Enter project website: " project_website
read -p "Enter namespace: " namespace
read -p "Enter repository URL: " repository_url

# Convert project name to various formats
project_name_hyphenated=$(to_hyphenated "$project_name")
project_name_underscored=$(to_underscored "$project_name")

# Rename directories
mv mu-plugins/scaffold mu-plugins/"$project_name_hyphenated"
mv themes/scaffold themes/"$project_name_hyphenated"

# Rename main plugin file
mv mu-plugins/"$project_name_hyphenated"/scaffold.php mu-plugins/"$project_name_hyphenated"/"$project_name_hyphenated".php

# Replace namespace in PHP files
find mu-plugins/"$project_name_hyphenated" -type f -name "*.php" -exec sed -i '' "s/namespace Scaffold/namespace $namespace/g" {} +

# Replace variable prefixes in PHP files
find mu-plugins/"$project_name_hyphenated" -type f -name "*.php" -exec sed -i '' "s/\$scaffold/\$$project_name_underscored/g" {} +

# Replace @package documentation
find mu-plugins/"$project_name_hyphenated" -type f -name "*.php" -exec sed -i '' "s/@package scaffold/@package $project_name_hyphenated/g" {} +

# Update theme style.css
sed -i '' "s/Theme Name: Scaffold/Theme Name: $project_name/g" themes/"$project_name_hyphenated"/css/style.css
sed -i '' "s/The WordPress theme for Scaffold/The WordPress theme for $project_name/g" themes/"$project_name_hyphenated"/css/style.css
sed -i '' "s/Text Domain: scaffold/Text Domain: $project_name_hyphenated/g" themes/"$project_name_hyphenated"/css/style.css

# Update package.json
sed -i '' "s/\"name\": \"scaffold\"/\"name\": \"$project_name_hyphenated\"/g" package.json
sed -i '' "s|https://github.com/happyprime/scaffold#readme|$project_website|g" package.json
sed -i '' "s|git+https://github.com/happyprime/scaffold.git|$repository_url|g" package.json
sed -i '' "s|https://github.com/happyprime/scaffold/issues|$repository_url/issues|g" package.json
sed -i '' "s/\"description\": \".*\"/\"description\": \"The $project_website website.\"/g" package.json

# Update composer.json
sed -i '' "s/\"name\": \"happyprime\/scaffold\"/\"name\": \"happyprime\/$project_name_hyphenated\"/g" composer.json

# Update .gitignore
sed -i '' "s!/themes/scaffold!/themes/$project_name_hyphenated!" .gitignore
sed -i '' "s!/mu-plugins/scaffold!/mu-plugins/$project_name_hyphenated!" .gitignore

# Update .deploy_include
sed -i '' "s!/themes/scaffold!/themes/$project_name_hyphenated!" .deploy_include

# Replace PHP constants
find . -type f -name "*.php" -exec sed -i '' "s/SCAFFOLD_MU_PLUGIN_DIR/${project_name_underscored}_MU_PLUGIN_DIR/g" {} +
find . -type f -name "*.php" -exec sed -i '' "s/SCAFFOLD_MU_PLUGIN_FILE/${project_name_underscored}_MU_PLUGIN_FILE/g" {} +

# Replace text domain strings (with single quotes)
find . -type f -name "*.php" -exec sed -i '' "s/'scaffold'/'$project_name_hyphenated'/g" {} +

# Replace text domain in theme template files
find themes/"$project_name_hyphenated" -type f -name "*.php" -exec sed -i '' "s/scaffold/$project_name_hyphenated/g" {} +

# Update package.json script paths
sed -i '' "s/mu-plugins\/scaffold/mu-plugins\/$project_name_hyphenated/g" package.json
sed -i '' "s/themes\/scaffold/themes\/$project_name_hyphenated/g" package.json

echo "Scaffolding complete! Project has been renamed to $project_name_hyphenated"

echo -e "\nChecking for remaining instances of 'scaffold' (case insensitive):"
find . -type f -not -path "*/\.*" -not -path "*/node_modules/*" -not -path "*/vendor/*" -exec grep -l -i "scaffold" {} \;
