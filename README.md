# Introduction
Project EV box/Chargebox for IRC.

## About
Administrative application, viewing entries in database and make reservations

### Technologies used
- Symfony (backend)
- Postgresql
- Twig (template)
- Tailwind
- Docker
- Adminer

### What is working?
- Used data fixtures to load test data automatically
- All tables that should be related are related, ex Car and Person, Reservations to connector and person etc.
- Able to make reservations for selected person and selected connector, connectors that have the in use boolean to true wil not show up in drop down, reservation end time is automatically +2hrs

### TODO
- Styling
- Wattage for connectors are not yet implemented
- Being able to add people, cars, ... via webapp
- Date for reservation validator -> future

