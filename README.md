# S360 Search Module

## Overview

The S360 Search module provides common functionality to support S
a specialized "Search Index" display mode for nodes that demonstrates a stripped-down version of content intended for search indexing, content analysis, or AI applications. This module allows administrators to control which paragraph types are included in the search index view and restricts access through custom permissions.

## Features

- **Custom Permission**: Adds "View Search Index" permission to control access to the search index display
- **Search Index Route**: Provides a dedicated route `/node/{nid}/search_index` for viewing nodes in search index mode
- **Paragraph Filtering**: Allows administrators to exclude specific paragraph types from the search index display
