# Overview

Tewiiq is a fully functional Arabic social media application built with PHP that provides Twitter-like functionality. The application includes complete user authentication, posting capabilities, user profiles, social networking features (follow/unfollow), and interactive elements (like/unlike). It's designed with a modern, responsive interface supporting Arabic (RTL) text display with beautiful Bootstrap 5 styling.

## Current Status
- ✅ Complete PHP web application with MVC architecture
- ✅ User registration and authentication system
- ✅ Tweet posting and viewing functionality
- ✅ User profiles with follow/unfollow system
- ✅ Like/unlike tweets functionality
- ✅ Tweet detail pages with replies and threading
- ✅ Advanced search functionality with filtering
- ✅ User settings and preferences management
- ✅ Lists and groups functionality
- ✅ Events and live broadcasting features
- ✅ **NEW**: Direct messaging system with real-time chat
- ✅ **NEW**: Comprehensive followers/following management
- ✅ **NEW**: Reels/short videos system with interactions
- ✅ **NEW**: Enhanced navigation with mobile support
- ✅ **NEW**: User search and suggestions system
- ✅ SQLite database with comprehensive schema
- ✅ Responsive Arabic RTL interface
- ✅ Server running on port 5000

## Demo Credentials
- Username: ahmed_dev
- Password: password123

# User Preferences

Preferred communication style: Simple, everyday language.

# System Architecture

## Frontend Architecture
- **Template Engine**: League Plates for native PHP templating without new syntax to learn
- **UI Framework**: Bootstrap 5.3 for responsive design and component library
- **Icons**: Bootstrap Icons and Font Awesome for consistent iconography
- **Fonts**: Google Fonts (Tajawal, Cairo) optimized for Arabic text rendering
- **Styling**: CSS3 with custom variables for theme switching (light/dark mode)
- **Layout**: RTL (right-to-left) support for Arabic language with dir="rtl"
- **Responsive Design**: Mobile-first approach with fluid containers and responsive breakpoints

## Backend Architecture
- **Framework**: Vanilla PHP with Composer dependency management
- **ORM**: RedBean PHP for database operations with zero-configuration approach
- **Environment**: PHP dotenv for configuration management
- **Architecture Pattern**: MVC-like structure with templates separated from logic
- **File Structure**: Organized with separate directories for templates, static assets, and vendor dependencies
- **Controllers**: Comprehensive controller system including:
  - `AuthController`: User authentication and registration
  - `HomeController`: Main timeline and tweet management
  - `ProfileController`: User profile management and following
  - `TweetDetailController`: Individual tweet pages with replies
  - `SearchController`: Advanced search and filtering
  - `SettingsController`: User preferences and account management
  - `ListController`: User-created lists and groups
  - `EventController`: Live events and broadcasting features
  - `ChatController`: Direct messaging and conversation management
  - `FollowingController`: Followers/following pages and user suggestions
  - `ReelController`: Short video content creation and interaction

## Data Storage
- **ORM**: RedBean PHP v5.7.5 providing automatic table creation and relationship mapping
- **Database**: SQLite database (tewiiq.db) for simplicity and portability
- **Schema**: Comprehensive database schema with 15+ tables including:
  - `users`: User accounts and profiles
  - `tweets`: Main tweet content
  - `replies`: Tweet replies with threading support
  - `likes`: Tweet like relationships
  - `replylikes`: Reply like relationships
  - `follows`: User follow relationships
  - `tweetlists`: User-created lists and groups
  - `listmembers`: List membership relationships
  - `events`: Live events and broadcasting
  - `eventparticipants`: Event participation tracking
  - `usersettings`: User preferences and configurations
  - `conversations`: Direct message conversations
  - `messages`: Individual chat messages
  - `reels`: Short video content
  - `reel_likes`: Reel interaction likes
  - `reel_comments`: Comments on reels
  - `reel_views`: View tracking for reels
- **Data Access**: Active Record pattern through RedBean's bean objects
- **Sample Data**: Includes pre-populated users, tweets, and follow relationships

## Authentication & Authorization
- **Session Management**: PHP native sessions for user state management
- **User Authentication**: Traditional username/password authentication system
- **Registration**: User registration with form validation
- **Profile Management**: User profile pages with customizable information
- **Access Control**: Template-based permission checking for protected content

## External Dependencies

### Core Dependencies
- **gabordemooij/redbean (^5.7)**: Zero-configuration ORM for database operations
- **league/plates (^3.4)**: Native PHP template system for view rendering
- **vlucas/phpdotenv (^5.0)**: Environment variable management for configuration

### Frontend Dependencies (CDN)
- **Bootstrap 5.3**: CSS framework for responsive UI components
- **Bootstrap Icons**: Icon library for consistent interface elements
- **Font Awesome 6.4**: Additional icon library for enhanced UI
- **Google Fonts**: Tajawal and Cairo fonts for Arabic text optimization

### Supporting Libraries
- **Symfony Polyfills**: Compatibility layers for ctype, mbstring, and PHP 8.0 features
- **Graham Campbell Result Type**: Type safety utilities for error handling
- **PHP Option**: Optional type implementation for safer null handling

### Development Tools
- **Composer**: Dependency management and autoloading
- **PSR-4 Autoloading**: Standard autoloading for organized code structure

The application follows modern PHP practices with a focus on simplicity and maintainability, using proven libraries for core functionality while maintaining Arabic language support throughout the user interface.