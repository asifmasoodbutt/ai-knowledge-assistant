# Recommended Folder Structure

## Laravel Structure

```text
app/
 ├── Http/
 │    ├── Controllers/
 │    │    └── API/
 │    ├── Requests/
 │    └── Resources/
 │
 ├── Services/
 │    ├── AI/
 │    ├── Document/
 │    ├── Chat/
 │    └── Vector/
 │
 ├── Repositories/
 │
 ├── Interfaces/
 │    └── Repositories/
 │
 ├── Jobs/
 │    ├── ProcessDocumentJob.php
 │    └── GenerateEmbeddingsJob.php
 │
 ├── Models/
 │
 └── Helpers/
```

---

## Python AI Service Structure

```text
python-ai-service/
 ├── app/
 │    ├── api/
 │    ├── services/
 │    ├── embeddings/
 │    ├── vector_store/
 │    ├── rag/
 │    ├── llm/
 │    └── utils/
 │
 ├── main.py
 ├── requirements.txt
 └── .env
```

---

## Storage Structure

```text
storage/app/public/users/
 └── {user_id}/
      ├── documents/
      ├── temp/
      └── processed/
```

---

# 📘 API_SPECIFICATION.md

# API Specification

## Laravel APIs

---

## Authentication

### Register

```http
POST /api/register
```

### Login

```http
POST /api/login
```

---

## Documents

### Upload Document

```http
POST /api/documents/upload
```

### List Documents

```http
GET /api/documents
```

### Delete Document

```http
DELETE /api/documents/{id}
```

---

## Chat APIs

### Send Message

```http
POST /api/chat/message
```

### Chat History

```http
GET /api/chat/history
```

---

## Python AI Service APIs

---

## Health Check

```http
GET /health
```

---

## Ingest Document Chunks

```http
POST /ingest
```

### Request Example

```json
{
  "document_id": 1,
  "chunks": [
    "chunk one",
    "chunk two"
  ]
}
```

---

## Query Endpoint

```http
POST /query
```

### Request Example

```json
{
  "user_id": 1,
  "query": "What is this document about?"
}
```