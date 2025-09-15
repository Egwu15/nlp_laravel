# Nigerian Law App - Model Structure Summary

This document provides a comprehensive overview of the model structures in the Nigerian Law App and how they are related to each other.

## Core Models

### User Model
- **Fields**: first_name, last_name, email, password, role, is_active
- **Relationships**:
  - Has many UserSubscriptions
  - Has method to access active subscriptions (where end date is in the future)
- **Special Features**:
  - Role-based access control (Admin role check)
  - Name attribute accessor that combines first and last name

### AccessPlan Model
- **Fields**: name, description, active, price, duration_days, discount_price, discount_expires_at
- **Relationships**:
  - Morphed by many Laws (polymorphic)
  - Morphed by many CourtRules (polymorphic)
  - Has many UserSubscriptions
- **Purpose**: Defines subscription plans that users can purchase to access premium content

### UserSubscription Model
- **Fields**: user_id, access_plan_id, starts_at, ends_at, is_renewing
- **Relationships**:
  - Belongs to User
  - Belongs to AccessPlan
- **Purpose**: Tracks user subscriptions to access plans with time periods

## Law-Related Models (Hierarchical Structure)

### Category Model
- **Fields**: name
- **Relationships**:
  - Has many Laws
- **Purpose**: Categorizes laws into different groups

### Law Model
- **Fields**: title, category_id, description, is_free, is_published
- **Relationships**:
  - Belongs to Category
  - Has many Chapters
  - Has many Sections
  - Has many through relationship with Parts via Chapters
  - Has many Schedules
  - Morphs to many AccessPlans (polymorphic)
- **Purpose**: Represents a legal document/act

### Chapter Model
- **Fields**: title, law_id, number
- **Relationships**:
  - Belongs to Law
  - Has many Parts
- **Purpose**: Represents chapters within a law

### Part Model
- **Fields**: title, chapter_id, number
- **Relationships**:
  - Belongs to Chapter
  - Has many Sections
  - Has method to access related Law through Chapter
- **Purpose**: Represents parts within a chapter of a law

### Section Model
- **Fields**: content, number, part_id, law_id
- **Relationships**:
  - Belongs to Part
  - Belongs to Law (direct reference for optimization)
- **Special Features**:
  - Auto-sets law_id based on the part's chapter's law when saving
- **Purpose**: Contains the actual legal text content

### Schedule Model
- **Fields**: Not fully examined, but related to Law
- **Relationships**:
  - Belongs to Law
- **Purpose**: Represents schedules/appendices to laws

## Court Rules Models (Hierarchical Structure)

### CourtRule Model
- **Fields**: title, description, is_published, is_free
- **Relationships**:
  - Has many OrderRules
  - Has many Rules
  - Morphs to many AccessPlans (polymorphic)
- **Purpose**: Represents a set of court rules

### OrderRule Model
- **Fields**: title, number, court_rule_id
- **Relationships**:
  - Belongs to CourtRule
  - Has many Rules
- **Purpose**: Represents orders within court rules

### Rule Model
- **Fields**: title, number, content, court_rule_id, order_rule_id
- **Relationships**:
  - Belongs to CourtRule
  - Belongs to OrderRule
- **Purpose**: Contains the actual rule text and can be associated with both a CourtRule and an OrderRule

## Other Models

### LegalTerm Model
- **Fields**: term, definition
- **Purpose**: Dictionary of legal terminology

### WordOfTheDay Model
- **Fields**: Not fully examined
- **Purpose**: Likely provides daily legal terms or concepts

### AppForceUpDate Model
- **Fields**: Not fully examined
- **Purpose**: Likely manages app update requirements

## Polymorphic Relationships

The system uses polymorphic relationships to connect AccessPlans to different types of content:

- **access_planables table**:
  - Fields: access_plan_id, access_planable_id, access_planable_type
  - Purpose: Implements many-to-many polymorphic relationships between AccessPlans and other models (Law, CourtRule)
  - This allows different types of content to be associated with subscription plans

## Key Relationships Summary

1. **Content Hierarchy**:
   - Laws → Chapters → Parts → Sections (legal document structure)
   - CourtRules → OrderRules → Rules (court rules structure)

2. **Access Control**:
   - Users → UserSubscriptions → AccessPlans → Content (Laws/CourtRules)
   - This chain controls what content users can access based on their subscriptions

3. **Content Organization**:
   - Categories → Laws (categorization of legal documents)

## Database Design Patterns

1. **Polymorphic Relationships**: Used for flexible content access control
2. **Hierarchical Data**: Multiple levels of parent-child relationships for structured content
3. **Direct References**: Some models include direct references to higher-level ancestors for query optimization (e.g., Section has law_id)
4. **Temporal Data**: Subscription models include time-based fields (starts_at, ends_at)
5. **Status Flags**: Models use boolean flags for status (is_published, is_free, is_active, etc.)
