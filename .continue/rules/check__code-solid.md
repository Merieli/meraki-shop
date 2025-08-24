---
name: SOLID Analysis Rules
description: Regras para desenvolvimento com Laravel 11.x
---

Please analyze the provided code and evaluate how well it adheres to each of the SOLID principles on a scale of 1-10, where:

1 = Completely violates the principle
10 = Perfectly implements the principle

For each principle, provide:
- Numerical rating (1-10)
- Brief justification for the rating
- Specific examples of violations (if any)
- Suggestions for improvement
- Positive aspects of the current design

## Single Responsibility Principle (SRP)
Rate how well each class/function has exactly one responsibility and one reason to change.
Consider:
- Does each component have a single, well-defined purpose?
- Are different concerns properly separated (UI, business logic, data access)?
- Would changes to one aspect of the system require modifications across multiple components?

## Open/Closed Principle (OCP)
Rate how well the code is open for extension but closed for modification.
Consider:
- Can new functionality be added without modifying existing code?
- Is there effective use of abstractions, interfaces, or inheritance?
- Are extension points well-defined and documented?
- Are concrete implementations replaceable without changes to client code?

## Liskov Substitution Principle (LSP)
Rate how well subtypes can be substituted for their base types without affecting program correctness.
Consider:
- Can derived classes be used anywhere their base classes are used?