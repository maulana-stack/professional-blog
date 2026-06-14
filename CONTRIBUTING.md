# Contributing to Professional Blog

We welcome contributions from the community! This document provides guidelines and instructions for contributing.

## How to Contribute

### Reporting Bugs
1. Check if the bug has already been reported
2. Include a clear description of the bug
3. Provide steps to reproduce
4. Include expected and actual behavior
5. Add screenshots if applicable

### Feature Requests
1. Check if the feature has already been requested
2. Describe the feature in detail
3. Explain the use case and benefits
4. Include mockups or examples if possible

### Pull Requests
1. Fork the repository
2. Create a feature branch: `git checkout -b feature/amazing-feature`
3. Make your changes
4. Write or update tests
5. Commit with clear messages: `git commit -m 'Add amazing feature'`
6. Push to your branch: `git push origin feature/amazing-feature`
7. Open a Pull Request

## Code Style

### PHP
- Follow PSR-12 coding standards
- Use meaningful variable and function names
- Add docblocks to classes and methods
- Keep methods focused and small

### Blade Templates
- Use consistent indentation (2 spaces)
- Use meaningful class names
- Avoid inline styles

### CSS/Tailwind
- Use Tailwind utility classes
- Avoid custom CSS when possible
- Keep component styles in app.css

### JavaScript
- Use const/let instead of var
- Add comments for complex logic
- Use meaningful names

## Development Workflow

1. **Setup Development Environment**
   ```bash
   git clone <your-fork>
   cd professional-blog
   composer install
   npm install
   ```

2. **Create Feature Branch**
   ```bash
   git checkout -b feature/your-feature
   ```

3. **Make Changes**
   - Write code
   - Add tests if applicable
   - Update documentation

4. **Test Locally**
   ```bash
   php artisan serve
   npm run dev
   ```

5. **Commit and Push**
   ```bash
   git add .
   git commit -m "feat: add awesome feature"
   git push origin feature/your-feature
   ```

## Commit Message Format

```
<type>(<scope>): <subject>

<body>

<footer>
```

### Type
- **feat**: A new feature
- **fix**: A bug fix
- **docs**: Documentation changes
- **style**: Code style changes
- **refactor**: Code refactoring
- **perf**: Performance improvements
- **test**: Test changes
- **chore**: Build process, dependencies, etc.

### Example
```
feat(posts): add post scheduling functionality

Allow users to schedule posts for future publication.
Posts can be set to publish at a specific date/time.

Closes #123
```

## Testing

Run tests before submitting a PR:
```bash
php artisan test
```

## Questions?

- Create an issue with the `question` label
- Join our community discussions
- Email maintainers

Thank you for contributing! 🎉
