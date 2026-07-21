#!/usr/bin/env bash
#
# git-sync.sh — sincronizza il branch corrente con origin usando pull --rebase.
# Se ci sono modifiche locali non committate, le mette da parte (stash),
# fa il pull, e le riapplica.
#
# Uso:
#   ./git-sync.sh
#
set -e

# Vai alla root del repo (utile se lo script viene lanciato da una sottocartella)
cd "$(git rev-parse --show-toplevel 2>/dev/null)" || {
  echo "❌ Non sembra una repo Git."
  exit 1
}

BRANCH=$(git symbolic-ref --short HEAD)
echo "🔄 Sync del branch '$BRANCH'..."

# Controlla se ci sono modifiche locali non committate
STASHED=0
if ! git diff-index --quiet HEAD --; then
  echo "📦 Modifiche locali trovate, le metto da parte temporaneamente..."
  git stash push -u -m "git-sync.sh auto-stash"
  STASHED=1
fi

# Pull con rebase
if git pull --rebase --tags origin "$BRANCH"; then
  echo "✅ Pull completato senza conflitti."
else
  echo "⚠️  Conflitti durante il rebase. Risolvili manualmente, poi:"
  echo "    git add <file>"
  echo "    git rebase --continue"
  if [ "$STASHED" -eq 1 ]; then
    echo "    git stash pop   # per recuperare le modifiche messe da parte"
  fi
  exit 1
fi

# Riapplica le modifiche locali, se erano state messe da parte
if [ "$STASHED" -eq 1 ]; then
  echo "📦 Riapplico le modifiche locali..."
  if ! git stash pop; then
    echo "⚠️  Conflitto nel riapplicare lo stash. Risolvilo manualmente,"
    echo "    poi lancia: git stash drop  (quando sei sicuro sia tutto ok)"
    exit 1
  fi
fi

echo "✨ Tutto sincronizzato."