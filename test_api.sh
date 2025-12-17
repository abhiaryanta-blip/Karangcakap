#!/bin/bash

# Test Gemini API directly with curl
API_KEY="AIzaSyA7wCSCSKPecLhBdApJkSkWuweTYo0NLSs"
URL="https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=$API_KEY"

PAYLOAD='{"contents": [{"parts": [{"text": "Apa itu terumbu karang?"}]}]}'

echo "Testing Gemini API..."
echo "URL: $URL"
echo "Payload: $PAYLOAD"
echo ""

curl -X POST \
  -H "Content-Type: application/json" \
  -d "$PAYLOAD" \
  "$URL" | jq .

echo ""
echo "Test complete"
