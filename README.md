# Event Management System

## Overview

This project is an Event Management System where users can authenticate, create, view, and register for events. The application is designed to be simple, efficient, and secure, with core features like user authentication, event creation and management, attendee registration, event dashboards, and CSV export for reports.

## Features

### 1. Core Functionalities
- **User Authentication**: Allows users to log in and register with secure password hashing for authentication.
- **Event Management**: Authenticated users can create, update, view, and delete events with details such as name, description, and event date.
- **Attendee Registration**: Users can register for events, with the system ensuring that no more than the maximum allowed number of attendees is registered.
- **Event Dashboard**: Displays a list of events in a paginated, sortable, and filterable format to enhance user experience.
- **Event Reports**: Admins can download attendee lists in CSV format for any event.

### 2. Technical Requirements
- **Backend**: Developed using pure PHP (no frameworks).
- **Database**: MySQL is used for data storage.
- **Security**: Implements both client-side and server-side validation, with SQL prepared statements to protect against SQL injection.
- **UI**: A basic responsive user interface using **Bootstrap**.
  
## Setup Instructions

### Prerequisites
Before you begin, ensure you have the following installed:
- PHP (version 7.4 or higher)
- MySQL (or MariaDB)
- A web server such as Apache or Nginx

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/event-management-system.git
cd event-management-system
