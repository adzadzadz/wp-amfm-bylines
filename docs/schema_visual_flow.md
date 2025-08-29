# Schema System Visual Flow

## 🏗️ System Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                     WordPress Admin                          │
├─────────────────────────────────────────────────────────────┤
│  Page Editor                                                 │
│  ┌─────────────────────────────────────────┐               │
│  │ ACF Custom Schema Field (JSON)          │               │
│  │ ┌───────────────────────────────────┐   │               │
│  │ │ {                                 │   │               │
│  │ │   "@context": "...",              │   │               │
│  │ │   "@graph": [                     │   │               │
│  │ │     {{location brand="mc"}},      │ ◄─── Shortcodes   │
│  │ │     {                             │   │               │
│  │ │       "@type": "MedicalCondition" │   │               │
│  │ │       ...                         │   │               │
│  │ └───────────────────────────────────┘   │               │
│  └─────────────────────────────────────────┘               │
└─────────────────────────────────────────────────────────────┘
                              │
                              ▼
```

## 🔄 Processing Pipeline

```
┌──────────────────────────────────────────────────────────────┐
│                   Frontend Page Load                         │
└──────────────────────────────────────────────────────────────┘
                              │
                              ▼
        ┌─────────────────────────────────────┐
        │  Check: Custom Schema Field Exists? │
        └─────────────────────────────────────┘
                    /                \
                  YES                 NO
                   │                   │
                   ▼                   ▼
    ┌──────────────────────┐   ┌──────────────────┐
    │ Parse Shortcodes     │   │ Use Only Byline  │
    │ in Custom Schema     │   │ Module Schema    │
    └──────────────────────┘   └──────────────────┘
                   │                   │
                   ▼                   │
    ┌──────────────────────┐          │
    │ Process Shortcodes:  │          │
    │ • {{location}}       │          │
    │ • {{breadcrumbs}}    │          │
    └──────────────────────┘          │
                   │                   │
                   ▼                   │
    ┌──────────────────────┐          │
    │ Fetch ML_JSON Data   │          │
    │ (Master Locations)   │          │
    └──────────────────────┘          │
                   │                   │
                   ▼                   │
    ┌──────────────────────┐          │
    │ Apply Filters:       │          │
    │ • Brand (e.g. "mc")  │          │
    │ • Region             │          │
    │ • State              │          │
    └──────────────────────┘          │
                   │                   │
                   ▼                   │
    ┌──────────────────────┐          │
    │ Generate Dynamic     │          │
    │ Schema Components    │          │
    └──────────────────────┘          │
                   │                   │
                   ▼                   │
    ┌──────────────────────┐          │
    │ Merge with Byline    │          │
    │ Module Schema        │          │
    └──────────────────────┘          │
                   │                   │
                   └───────┬───────────┘
                           ▼
        ┌─────────────────────────────────────┐
        │     Output Final Schema to Page     │
        │  <script type="application/ld+json"> │
        └─────────────────────────────────────┘
```

## 📊 Data Flow Example

```
INPUT (ACF Field):
┌─────────────────────┐
│ Custom Schema with  │
│ {{location brand=   │
│ "mc"}} shortcode    │
└─────────────────────┘
         │
         ▼
PROCESSING:
┌─────────────────────┐     ┌─────────────────────┐
│ ML_JSON Database    │────▶│ Filter by brand="mc"│
│ ┌─────────────────┐ │     └─────────────────────┘
│ │Location 1: VA   │ │              │
│ │Location 2: WA   │ │              ▼
│ │Location 3: CA   │ │     ┌─────────────────────┐
│ │Location 4: TX   │ │     │ Generate 5 Medical  │
│ │Location 5: VA   │ │     │ Clinic entries      │
│ └─────────────────┘ │     └─────────────────────┘
└─────────────────────┘              │
         │                            ▼
         ▼                   ┌─────────────────────┐
┌─────────────────────┐     │ Replace shortcode   │
│ Byline Module       │     │ with generated JSON │
│ Schema (existing)   │     └─────────────────────┘
└─────────────────────┘              │
         │                            │
         └────────────┬───────────────┘
                      ▼
OUTPUT:
┌──────────────────────────────────────┐
│ Combined Schema:                     │
│ • MedicalOrganization (dynamic)      │
│ • MedicalClinic[] (5 locations)      │
│ • MedicalCondition (from ACF)        │
│ • FAQPage (from ACF)                 │
│ • Offer (from ACF)                   │
│ • + Byline Module Schema             │
└──────────────────────────────────────┘
```

## 🎯 Key Components

### 1. Master Location JSON Structure
```
ML_JSON
├── Business name
├── (Internal) Shortname  ◄── Brand filter
├── Street
├── Unit
├── City
├── State                 ◄── State filter
├── Zipcode
├── GMB_Phone
└── Region                 ◄── Region filter
```

### 2. Shortcode Parameters
```
{{location brand="mc"}}           → Filter by brand
{{location region="northwest"}}   → Filter by region
{{location state="WA"}}          → Filter by state
{{breadcrumbs}}                   → Insert breadcrumb schema
```

### 3. Schema Merging Priority
```
1. Byline Module Schema (always present)
       +
2. Custom ACF Schema (if exists)
       +
3. Dynamic replacements (locations, breadcrumbs)
       ↓
   Final Output
```

## 🔧 Implementation Requirements

```
┌───────────────────────────────────────────┐
│           Backend Components              │
├───────────────────────────────────────────┤
│ 1. ACF Field Registration                │
│ 2. Shortcode Parser                      │
│ 3. ML_JSON Data Handler                  │
│ 4. Schema Generator                      │
│ 5. Schema Merger                         │
│ 6. Frontend Output Hook                  │
└───────────────────────────────────────────┘
```

## 📝 Use Cases

```
Page Type: Mental Health Condition
├── Custom Schema: MedicalCondition, FAQ, Offer
├── Shortcode: {{location brand="mc"}}
└── Result: Full medical schema with 5 clinic locations

Page Type: Treatment Center
├── Custom Schema: HealthAndBeautyBusiness
├── Shortcode: {{location state="CA"}}
└── Result: Schema with only California locations

Page Type: Blog Post
├── Custom Schema: None
├── Shortcode: N/A
└── Result: Only byline module schema
```