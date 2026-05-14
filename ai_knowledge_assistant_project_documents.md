# AI Knowledge Assistant — Project Documentation

# 📘 ARCHITECTURE.md

# AI Knowledge Assistant Architecture

## Overview

The AI Knowledge Assistant is a production-style Retrieval-Augmented Generation (RAG) SaaS application that enables users to upload documents and interact with them using natural language.

The architecture is intentionally divided into two main services:

1. Laravel Backend Application
2. Python AI Microservice

This separation allows the system to:
- Maintain clean architecture
- Scale AI workloads independently
- Keep responsibilities isolated
- Use the best ecosystem for each problem domain

---

## High-Level Architecture

```text
User
 ↓
Frontend (Blade / React)
 ↓
Laravel Backend API
 ├── Authentication
 ├── File Uploads
 ├── Business Logic
 ├── Queues
 ├── Chat Management
 ↓
Redis Queue
 ↓
Python AI Service (FastAPI)
 ├── Embedding Generation
 ├── Vector Search
 ├── RAG Pipeline
 ├── LLM Communication
 ↓
FAISS Vector Database
 ↓
Ollama Local LLM
```

---

## Laravel Responsibilities

Laravel acts as the main application layer.

### Responsibilities
- Authentication & Authorization
- User Management
- Multi-tenancy
- File Uploads
- Queue Management
- Chat Management
- API Layer
- Business Rules
- Logging
- Caching
- Rate Limiting

---

## Python AI Service Responsibilities

The Python service handles all AI-related processing.

### Responsibilities
- Text chunking
- Embedding generation
- Semantic similarity search
- RAG orchestration
- LLM communication
- Context assembly

---

## RAG Pipeline

### Document Ingestion

1. User uploads document
2. Laravel stores file
3. Queue job dispatches processing
4. Python service extracts text
5. Text is chunked
6. Embeddings generated
7. Embeddings stored in FAISS

### Query Pipeline

1. User submits question
2. Query embedding generated
3. Similar chunks retrieved
4. Context assembled
5. LLM generates response
6. Response returned to user

---

## Architectural Principles

### Separation of Concerns
- Laravel handles business logic
- Python handles AI logic

### Scalability
- Queue-based processing
- Independent AI service
- Stateless APIs

### Maintainability
- Modular services
- Clean service boundaries
- Repository/service pattern

### Cost Efficiency
- Local models initially
- Free tooling stack
- Replaceable components

---

## Future Scalability

Possible future upgrades:
- Replace Ollama with OpenAI API
- Replace FAISS with Pinecone
- Add Kubernetes
- Add streaming responses
- Add analytics dashboard
- Add hybrid search

---

# 📘 ROADMAP.md

# AI Knowledge Assistant Roadmap

## Phase 1 — Foundation

### Goals
- Setup Laravel backend
- Setup Python microservice
- Establish communication
- Build base chat system

### Deliverables
- Auth system
- API structure
- FastAPI service
- Basic AI chat

---

## Phase 2 — Document Processing

### Goals
- Upload documents
- Extract text
- Process asynchronously

### Deliverables
- File uploads
- Queue jobs
- PDF/TXT parsing
- Chunking system

---

## Phase 3 — Embeddings & Vector Search

### Goals
- Generate embeddings
- Store vectors
- Implement semantic search

### Deliverables
- sentence-transformers integration
- FAISS setup
- Vector retrieval system

---

## Phase 4 — RAG System

### Goals
- Connect retrieval + LLM
- Generate grounded responses

### Deliverables
- Query endpoint
- Context retrieval
- RAG pipeline
- AI response generation

---

## Phase 5 — Production Features

### Goals
- Improve reliability
- Improve scalability

### Deliverables
- Caching
- Logging
- Error handling
- Rate limiting
- Multi-user isolation

---

## Phase 6 — Polish & Portfolio

### Goals
- Prepare project for GitHub
- Improve usability
- Final cleanup

### Deliverables
- README
- Architecture docs
- Demo video
- Portfolio case study

---

# 📘 FOLDER_STRUCTURE.md

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

---

# 📘 SYSTEM_DESIGN.md

# System Design

## Design Goals

The project is designed with the following objectives:

- Learn AI engineering practically
- Build scalable backend architecture
- Understand RAG systems
- Practice microservice communication
- Implement production-like workflows

---

## Key Design Decisions

### Why Laravel?

Laravel provides:
- Fast API development
- Strong ecosystem
- Queue system
- Authentication
- Clean architecture support

---

### Why Python Microservice?

The AI ecosystem is Python-first.

Using a dedicated AI microservice allows:
- Better AI tooling support
- Cleaner architecture
- Easier future scaling

---

### Why Ollama?

Ollama allows:
- Free local inference
- Offline AI experimentation
- Lightweight development

---

### Why FAISS?

FAISS provides:
- Fast vector similarity search
- Lightweight local vector storage
- Good learning platform for RAG

---

### Why sentence-transformers?

This library provides:
- Easy embedding generation
- Lightweight models
- Strong semantic search support

---

## Database Design

### users
- id
- name
- email
- password

### documents
- id
- user_id
- file_name
- file_path
- status

### document_chunks
- id
- document_id
- chunk_text
- embedding_reference

### chats
- id
- user_id

### messages
- id
- chat_id
- role
- content

---

## Queue Workflow

### Upload Flow

1. User uploads file
2. Laravel stores file
3. Queue job dispatched
4. Python service processes data

---

## Error Handling Strategy

The system should gracefully handle:
- AI service downtime
- Invalid documents
- Queue failures
- Timeout errors
- Empty search results

---

## Security Considerations

- User-based data isolation
- Request validation
- Rate limiting
- File type validation
- Secure API communication

---

## Future Enhancements

- Streaming responses
- Hybrid search
- Multi-model support
- Document summarization
- Analytics dashboard
- Cloud deployment

---

# 📘 LEARNINGS.md

# Project Learnings

## AI Concepts

Topics to learn during this project:

- Embeddings
- Vector databases
- Semantic search
- RAG architecture
- Prompt engineering
- LLM workflows

---

## Backend Engineering Learnings

- Microservice communication
- Queue-based workflows
- AI system integration
- Async processing
- API orchestration

---

## DevOps Learnings

- Docker basics
- Service orchestration
- Local AI environment setup

---

## Portfolio Outcomes

By completing this project, the following skills will be demonstrated:

- AI backend engineering
- RAG implementation
- Production architecture
- Laravel + Python integration
- Scalable system design

---

# 📘 DEVELOPMENT_RULES.md

# Development Rules

## General Rules

- Keep architecture simple
- Build incrementally
- Avoid premature optimization
- Prioritize completion over perfection

---

## Laravel Rules

- Use service classes
- Use repository pattern where needed
- Keep controllers thin
- Validate requests properly

---

## Python Rules

- Keep endpoints focused
- Separate AI logic into services
- Avoid large monolithic files

---

## AI Rules

- Use smaller local models initially
- Keep prompts configurable
- Restrict responses to retrieved context

---

## Performance Rules

- Use queues for heavy tasks
- Cache repeated queries
- Avoid loading large files into memory unnecessarily

---

## Documentation Rules

- Document APIs
- Document architecture changes
- Keep README updated
- Record major learnings

