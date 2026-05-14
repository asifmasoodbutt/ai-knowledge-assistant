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