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