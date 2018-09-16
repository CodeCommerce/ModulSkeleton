# Modul is under construction! Not all function works default

# ModulSkeleton
Tool to generate Modules for OXID V6

## Installation
Via Composer 

    composer require codecommerce/module_skeleton --dev
    
## Configuration
Copy file from

    vendor/codecommerce/module_skeleton/Config/module_skeleton_persona.yml.dist
to
     
     source/skeleton/module_skeleton_personal.yml
     
Change your keys if you want to.
Have a look to vendor/codecommerce/module_skeleton/Config/module_skeleton_configuration.yml to see what settings you can change
   
## Usage
    php vendor/codecommerce/module_skeleton/modul_skeleton ox:mo:cr

