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

### Installation and how to start the project
1. Install and run Docker client
2. Copy project to prefered directory, navigate to project directory in terminal
3. Start the database container:
    "docker-compose up -d db"
4. Copy database dump to virtual docker machine
    "docker cp "C:\path\to\backup\chargebox_db_backup.dump" chargebox-db-1:/tmp/chargebox_db_backup.dump"
5. Restore database from dump copy
    "docker exec -it chargebox-db-1 pg_restore -U symfony -d chargebox -v /tmp/chargebox_db_backup.dump"
6. Build remaining containers
    "docker-compose up -d"
7. Navigate to local host in web browser
    the project should be on localhost, to access database: "http://localhost:8080", select postgresql, database: "chargebox", username: "symfony", password: "123"

