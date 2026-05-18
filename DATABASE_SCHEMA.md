# AI Knowledge Assistant — Database Schema

This document defines the recommended database schema for the AI Knowledge Assistant project.

The schema is designed to support:
- Multi-user SaaS architecture
- AI chat system
- Document processing
- RAG pipelines
- Usage tracking
- Scalability

---

# 🧑 Users Table

## Purpose
Stores application users.

## Table: users

| Column | Type | Notes |
|---|---|---|
| id | bigint | Primary key |
| name | string | User full name |
| email | string | Unique |
| password | string | Hashed password |
| email_verified_at | timestamp nullable | Email verification |
| remember_token | string nullable | Remember token |
| created_at | timestamp | |
| updated_at | timestamp | |

---

# 📄 Documents Table

## Purpose
Stores uploaded document metadata.

## Table: documents

| Column | Type | Notes |
|---|---|---|
| id | bigint | Primary key |
| user_id | bigint | FK → users.id |
| title | string | Optional document title |
| original_name | string | Original uploaded file name |
| stored_name | string | Internal stored name |
| file_path | string | Storage path |
| file_extension | string | pdf/txt/csv |
| mime_type | string | MIME type |
| file_size | bigint | File size in bytes |
| status | enum | pending/processing/completed/failed |
| extracted_text | longText nullable | Optional cached extracted text |
| processed_at | timestamp nullable | Processing completion time |
| created_at | timestamp | |
| updated_at | timestamp | |

---

# 📚 Document Chunks Table

## Purpose
Stores chunked text from documents.

## Table: document_chunks

| Column | Type | Notes |
|---|---|---|
| id | bigint | Primary key |
| document_id | bigint | FK → documents.id |
| chunk_index | integer | Chunk order |
| chunk_text | longText | Chunk content |
| token_count | integer nullable | Approx token count |
| embedding_reference | string nullable | FAISS/vector reference |
| metadata | json nullable | Additional metadata |
| created_at | timestamp | |
| updated_at | timestamp | |

---

# 💬 Chats Table

## Purpose
Stores user chat sessions.

## Table: chats

| Column | Type | Notes |
|---|---|---|
| id | bigint | Primary key |
| user_id | bigint | FK → users.id |
| title | string nullable | Auto-generated title |
| last_message_at | timestamp nullable | Chat activity tracking |
| created_at | timestamp | |
| updated_at | timestamp | |

---

# 📨 Messages Table

## Purpose
Stores chat messages.

## Table: messages

| Column | Type | Notes |
|---|---|---|
| id | bigint | Primary key |
| chat_id | bigint | FK → chats.id |
| role | enum | user/assistant/system |
| content | longText | Message content |
| prompt_tokens | integer nullable | Token usage |
| completion_tokens | integer nullable | Token usage |
| total_tokens | integer nullable | Token usage |
| response_time_ms | integer nullable | AI response duration |
| created_at | timestamp | |
| updated_at | timestamp | |

---

# 🔗 Message Sources Table

## Purpose
Maps AI responses to retrieved document chunks.

## Table: message_sources

| Column | Type | Notes |
|---|---|---|
| id | bigint | Primary key |
| message_id | bigint | FK → messages.id |
| document_chunk_id | bigint | FK → document_chunks.id |
| similarity_score | decimal(8,5) nullable | Retrieval score |
| created_at | timestamp | |
| updated_at | timestamp | |

---

# ⚙️ Processing Jobs Table

## Purpose
Tracks document processing lifecycle.

## Table: processing_jobs

| Column | Type | Notes |
|---|---|---|
| id | bigint | Primary key |
| document_id | bigint | FK → documents.id |
| job_type | enum | extraction/chunking/embedding |
| status | enum | pending/running/completed/failed |
| started_at | timestamp nullable | |
| completed_at | timestamp nullable | |
| error_message | text nullable | Failure reason |
| created_at | timestamp | |
| updated_at | timestamp | |

---

# 📊 Usage Logs Table

## Purpose
Tracks AI usage and analytics.

## Table: usage_logs

| Column | Type | Notes |
|---|---|---|
| id | bigint | Primary key |
| user_id | bigint | FK → users.id |
| chat_id | bigint nullable | FK → chats.id |
| message_id | bigint nullable | FK → messages.id |
| model_name | string nullable | Used model |
| prompt_tokens | integer nullable | |
| completion_tokens | integer nullable | |
| total_tokens | integer nullable | |
| estimated_cost | decimal(10,4) nullable | Simulated cost |
| request_type | string nullable | query/embedding/chat |
| created_at | timestamp | |
| updated_at | timestamp | |

---

# 🧾 AI Request Logs Table

## Purpose
Stores AI request/response metadata.

## Table: ai_request_logs

| Column | Type | Notes |
|---|---|---|
| id | bigint | Primary key |
| user_id | bigint nullable | FK → users.id |
| endpoint | string | Python endpoint |
| request_payload | longText nullable | Serialized payload |
| response_payload | longText nullable | Serialized response |
| status_code | integer nullable | HTTP status |
| duration_ms | integer nullable | Request duration |
| created_at | timestamp | |
| updated_at | timestamp | |

---

# 🚫 Failed AI Requests Table

## Purpose
Stores failed AI communications.

## Table: failed_ai_requests

| Column | Type | Notes |
|---|---|---|
| id | bigint | Primary key |
| user_id | bigint nullable | FK → users.id |
| endpoint | string | Failed endpoint |
| error_message | text | Error details |
| payload | longText nullable | Original request |
| retry_count | integer default 0 | Retry attempts |
| created_at | timestamp | |
| updated_at | timestamp | |

---

# 🧠 Vector Metadata Table (Optional)

## Purpose
Stores vector-related metadata if needed.

## Table: vector_metadata

| Column | Type | Notes |
|---|---|---|
| id | bigint | Primary key |
| document_chunk_id | bigint | FK → document_chunks.id |
| vector_id | string | FAISS vector ID |
| embedding_model | string nullable | Model name |
| vector_dimensions | integer nullable | Embedding dimensions |
| created_at | timestamp | |
| updated_at | timestamp | |

---

# 🔐 Personal Access Tokens

## Purpose
Laravel Sanctum authentication.

## Table: personal_access_tokens

Use Laravel default schema.

---

# 📦 Queue Tables (If Database Queue Used)

## Required Tables
- jobs
- failed_jobs
- job_batches

Use Laravel default queue migrations.

---

# 🔄 Recommended Relationships

## User Relationships

```php
User hasMany Documents
User hasMany Chats
User hasMany UsageLogs
```

---

## Document Relationships

```php
Document belongsTo User
Document hasMany DocumentChunks
Document hasMany ProcessingJobs
```

---

## Chat Relationships

```php
Chat belongsTo User
Chat hasMany Messages
```

---

## Message Relationships

```php
Message belongsTo Chat
Message hasMany MessageSources
```

---

# 📌 Recommended Enums

## Document Status

```php
pending
processing
completed
failed
```

---

## Processing Job Status

```php
pending
running
completed
failed
```

---

## Processing Job Types

```php
extraction
chunking
embedding
indexing
```

---

## Message Roles

```php
user
assistant
system
```

---

# 🚀 Recommended Indexes

## documents

```sql
INDEX(user_id)
INDEX(status)
```

---

## document_chunks

```sql
INDEX(document_id)
INDEX(chunk_index)
```

---

## chats

```sql
INDEX(user_id)
```

---

## messages

```sql
INDEX(chat_id)
INDEX(role)
```

---

## usage_logs

```sql
INDEX(user_id)
INDEX(chat_id)
INDEX(message_id)
```

---

# 🧠 Design Notes

## Why Separate document_chunks?

This allows:
- Better chunk management
- Easier debugging
- Better source attribution
- Future vector DB migrations

---

## Why Store Usage Logs?

This helps:
- Analytics
- Monitoring
- Cost estimation
- Future SaaS billing

---

## Why Store AI Request Logs?

This helps:
- Debugging
- Performance optimization
- Failure analysis
- Monitoring AI quality

---

# ✅ Recommended Initial Tables

For MVP, prioritize:

1. users
2. documents
3. document_chunks
4. chats
5. messages
6. message_sources

Then gradually add:
- usage_logs
- ai_request_logs
- vector_metadata
- processing_jobs

---

# 🏁 Final Recommendation

Start simple.

Do NOT build every optimization immediately.

Implement:
- core schema first
- scalable structure second
- advanced analytics later

